<?php

namespace App\Repository\Api\User;

use App\Http\Resources\AreaResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\AddressFavorite;
use App\Models\PhoneToken;
use App\Models\ResetCodePassword;
use App\Traits\FirebaseNotification;
use Carbon\Carbon;
use App\Models\Area;
use App\Models\City;
use App\Models\Trip;
use App\Models\User;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\TripRates;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use App\Repository\ResponseApi;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\TripRateResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class UserRepository extends ResponseApi implements UserRepositoryInterface
{
    use PhotoTrait, FirebaseNotification;

    public function getAllCities(): JsonResponse
    {
        $cities = City::with('area')->get();
        return self::returnResponseDataApi(CityResource::collection($cities), "تم الحصول علي بيانات جميع المدن بنجاح", 200);
    } // getAllCities

    public function getAllAreas(): JsonResponse
    {
        $area = Area::with('city')->get();
        return self::returnResponseDataApi(AreaResource::collection($area), "تم الحصول علي بيانات جميع المدن بنجاح", 200);
    } // getAllAreas

    public function register(Request $request): JsonResponse
    {
        try {

            $rules = [
                'name' => 'required|string|max:50',
                'email' => 'nullable|email',
                'phone' => 'required|numeric',
                'img' => 'nullable|image',
                'type' => 'required|in:user,driver',
                'birth' => 'required',
                'device_type' => 'required',
                'token' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules, [
                'phone.numeric' => 407,
                'phone.exists' => 408,
            ]);


            $checkUserPhone = User::where('phone', $request->phone)->first();
            if ($checkUserPhone) {
                return self::returnResponseDataApi(null, 'هذا الهاتف مستخدم بالفعل', 201, 201);
            }
            $checkUserEmail = User::where('email', $request->email)->first();
            if ($checkUserEmail) {
                return self::returnResponseDataApi(null, 'هذاالبريد الالكتروني مستخدم بالفعل', 201, 201);
            }


            if ($validator->fails()) {
                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {
                    $errors_arr = [
                        406 => 'Failed,Email already exists',
                        407 => 'Failed,Phone number must be an number',
                        408 => 'Failed,Phone already exists',
                    ];
                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, $errors_arr[$errors] ?? '', 422);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422, 422);
            }

            $existUser = User::query()
                ->where('phone', $request->phone)
                ->onlyTrashed()
                ->first();

            if ($existUser) {
                $endTime = Carbon::parse($existUser->deleted_at)->addDays(30);
                $now = Carbon::now();
                if ($now > $endTime) {
                    $existUser->forceDelete();
                } else {
                    return self::returnResponseDataApi(null, 'هناك حساب تم حذفه علي هذا الرقم يرجي الانتظار الي ' . $endTime->format('Y-m-d') . ' لتسجيل من جديد', 422, 422);

                }
            }

            if ($request->hasFile('img')) {
                $image = $this->saveImage($request->img, 'uploads/users', 'photo');
            }

            $storeNewUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('123456'),
                'phone' => $request->phone,
                'img' => $image ?? 'uploads/users/avatar.png',
                'type' => $request->type,
                'birth' => $request->birth,
                'status' => 1
            ]);

            if (isset($storeNewUser)) {
                $credentials = ['phone' => $request->phone, 'password' => '123456'];
                $storeNewUser['token'] = auth()->guard('user-api')->attempt($credentials);
                PhoneToken::query()->updateOrCreate(['user_id' => $storeNewUser['id'], 'device_type' => request()->device_type], [
                    'device_type' => request()->device_type,
                    'token' => request()->token
                ]);
                return self::returnResponseDataApi(new UserResource($storeNewUser), "تم تسجيل بيانات المستخدم بنجاح", 200, 200);
            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", 500, 500);
            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // register

    public function login(Request $request): JsonResponse
    {
        try {
            // Validation Rules
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'device_type' => 'required',
                'token' => 'required',
            ]);
            $checkPhone = User::where('phone', '=', $request->phone)
                ->withTrashed()
                ->first();
            if (!$checkPhone) {
                return self::returnResponseDataApi(null, 'الهاتف غير موجود', 422, 422);
            } else {
                $user = User::query()
                    ->where('phone', '=', $request->phone)
                    ->onlyTrashed()
                    ->first();
                if ($user) {
                    return self::returnResponseDataApi(null, "يوجد حساب محذوف بهذا الرقم يرجي التواصل مع الدعم", 409, 409);
                }

                // Check Validation Result
                if ($validator->fails()) {
                    $errors = $validator->errors()->first();
                    $statusCode = is_numeric($errors) ? $errors : 422;

                    return self::returnResponseDataApi(null, $errors, $statusCode, $statusCode);
                }

                // Authenticate User
                $credentials = ['phone' => $request->phone, 'password' => '123456'];
                $token = Auth::guard('user-api')->attempt($credentials);

                // Get User and Attach Token
                $user = Auth::guard('user-api')->user();
                $user['token'] = $token;

                // Update or Create PhoneToken
                PhoneToken::query()->updateOrCreate(
                    ['user_id' => $user->id, 'device_type' => $request->device_type],
                    ['device_type' => $request->device_type, 'token' => $request->token]
                );

                return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200, 200);
            }


        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500, 500);
        }

    } // login

    public
    function logout(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            /*
             * params
             * token
             */

            $rules = [
                'token' => 'required|exists:phone_tokens,token',
            ];
            $validator = Validator::make(request()->all(), $rules, [
                'token.exists' => 409,
            ]);

            if ($validator->fails()) {

                $errors = collect($validator->errors())->flatten(1)[0];
                if (is_numeric($errors)) {

                    $errors_arr = [
                        409 => 'Failed,token not exists',
                    ];

                    $code = collect($validator->errors())->flatten(1)[0];
                    return self::returnResponseDataApi(null, $errors_arr[$errors] ?? 500, $code);
                }
                return self::returnResponseDataApi(null, $validator->errors()->first(), 422, 422);
            }

            PhoneToken::query()
                ->where('user_id', $user->id)->where('token', '=', request()->token)
                ->forceDelete();
            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500, 500);
        }
    } // logout

    public
    function deleteAccount(): JsonResponse
    {

        try {

            $user = Auth::guard('user-api')->user();
            if ($user->type == 'driver') {

                return self::returnResponseDataApi(null, "حساب السائق غير مصرح له بالحذف", 403, 403);
            } else {
                $user->delete();
                Auth::guard('user-api')->logout();
                return self::returnResponseDataApi(null, "تم حذف الحساب بنجاح وتم تسجيل الخروج من التطبيق", 200);
            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500, 500);
        }
    } // deleteAccount

    public
    function userHome(): JsonResponse
    {
        $home['sliders'] = Slider::query()
            ->select('image', 'link')
            ->where('status', '=', true)
            ->get();

        foreach ($home['sliders'] as $key => $slider) {
            $home['sliders'][$key]['image'] = asset($slider->image);
        }

        $trips = Trip::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('type', 'new')
            ->whereDate('created_at', '>=', Carbon::now())
            ->orderBy('created_at', 'asc')
            ->get();

        $home['new_trips'] = TripResource::collection($trips);

        $home['user'] = new UserResource(User::find(Auth::user()->id));
        return self::returnResponseDataApi($home, "تم الحصول علي بيانات الرئيسية بنجاح", 200);
    } // user home

    public
    function editProfile(Request $request): JsonResponse
    {
        $user = User::find(Auth::user()->id);
        try {
            $rules = [
                'name' => 'required|string|max:50',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone' => 'required|numeric|unique:users,phone,' . $user->id,
                'img' => 'nullable|image',
                'birth' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules, [
                'email.unique' => 406,
                'phone.numeric' => 407,
                'phone.unique' => 408,
            ]);

            if ($validator->fails()) {
                $firstError = $validator->errors()->first();

                if (is_numeric($firstError)) {
                    $errorsArr = [
                        406 => 'Failed, Email already exists',
                        407 => 'Failed, Phone number must be a number',
                        408 => 'Failed, Phone already exists',
                    ];
                    return self::returnResponseDataApi(null, $errorsArr[$firstError] ?? 'Error occurred', $firstError);
                }

                return self::returnResponseDataApi(null, $firstError, 422);
            }

            if ($request->hasFile('img')) {
                $image = $this->saveImage($request->img, 'uploads/users', 'photo');
                if (file_exists($user->img)) {
                    unlink($user->img);
                }
            } else {
                $image = $user->img;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->img = $image;
            $user->birth = $request->birth;
            $user->save();


            if ($user->save()) {
                $user['token'] = $request->bearerToken();
                return self::returnResponseDataApi(new UserResource($user), "تم تحديث بيانات المستخدم بنجاح", 200);
            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", 500, 500);
            }
        } catch (\Exception $exception) {

            return self::returnResponseDataApi(null, $exception->getMessage(), 500, 500);
        }
    } // edit profile

    public
    function createTrip(Request $request): JsonResponse
    {
        try {
            $rules = [
                'from_address' => 'required',
                'from_long' => 'required',
                'trip_type' => 'required',
                'from_lat' => 'required',
                'to_address' => 'nullable',
                'to_long' => 'nullable',
                'to_lat' => 'nullable',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                return self::returnResponseDataApi(null, $firstError, 422);
            }
            $checkQuickTrip = Trip::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('trip_type', '!=', 'scheduled')
                ->where('ended', '=', 0)->latest()->first();
            if ($checkQuickTrip) {
                return self::returnResponseDataApi(null, 'هناك رحلة حالية لم تنتهي بعد لنفس العميل', 502, 200);
            }

            $createQuickTrip = Trip::query()
                ->create([
                    'from_address' => $request->from_address,
                    'from_long' => $request->from_long,
                    'from_lat' => $request->from_lat,
                    'to_address' => $request->to_address,
                    'to_long' => $request->to_long,
                    'to_lat' => $request->to_lat,
                    'user_id' => Auth::user()->id,
                    'type' => 'new',
                    'trip_type' => $request->trip_type,
                ]);

            if (isset($createQuickTrip)) {
                $this->sendFirebaseNotification(['title' => 'رحلة جديدة', 'body' => 'هناك رحلة جديدة في الانتظار'], null, 'all_driver');
                return self::returnResponseDataApi(new TripResource($createQuickTrip), "تم انشاء طلب الرحلة بنجاح", 201, 200);
            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", false, 500);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // start trip

    public
    function cancelTrip(Request $request): JsonResponse
    {
        try {
            $trip = Trip::query()
                ->where('user_id', '=', Auth::user()->id)
                ->where('type', '=', 'new')
                ->where('ended', '=', 0)
                ->where('id', '=', $request->trip_id)
                ->first();
            if ($trip) {
                $trip->delete();
                return self::returnResponseDataApi(null, 'تم الغاء الرحلة بنجاح', 200);
            } else {
                return self::returnResponseDataApi(null, "لا يوجد لديك اي رحلة جديدة بهذا المعرف", 500, 500);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // cancel trip

    public
    function createScheduleTrip(Request $request): JsonResponse
    {
        try {
            $rules = [
                'from_address' => 'required',
                'from_long' => 'required',
                'from_lat' => 'required',
                'to_address' => 'nullable',
                'to_long' => 'nullable',
                'to_lat' => 'nullable',
                'date' => 'required',
                'time' => 'required',
            ];

            $dateTimeString = $request->date . ' ' . $request->time;
            $scheduleDate = Carbon::createFromFormat('Y-m-d H:i:s', $dateTimeString);

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                return self::returnResponseDataApi(null, $firstError, 422);
            }

            $checkTrip = Trip::query()
                ->create([
                    'from_address' => $request->from_address,
                    'from_long' => $request->from_long,
                    'from_lat' => $request->from_lat,
                    'to_address' => $request->to_address,
                    'to_long' => $request->to_long,
                    'to_lat' => $request->to_lat,
                    'user_id' => Auth::user()->id,
                    'type' => 'new',
                    'trip_type' => 'scheduled',
                    'created_at' => $scheduleDate,
                ]);

            if (isset($checkTrip)) {
                return self::returnResponseDataApi(new TripResource($checkTrip), "تم انشاء طلب الرحلة مجدولة في وقت لاحق بنجاح", 201, 200);
            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", false, 500);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // start create Schedule Trip

    public
    function userAllTrip(Request $request): JsonResponse
    {
        try {
            if ($request->has('type')) {
                if ($request->type == 'reject') {
                    $trips = Trip::query()
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('type', '=', 'reject')
                        ->where('ended', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->latest()->get();
                    $data = $trips;
                } elseif ($request->type == 'complete') {
                    $trips = Trip::query()
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('type', '=', 'complete')
                        ->where('ended', '=', 1)
                        ->orderBy('created_at', 'DESC')
                        ->latest()->get();
                    $data = $trips;
                } else {
                    $trips = Trip::query()
                        ->where('type', '=', 'new')
                        ->where('user_id', '=', Auth::user()->id)
                        ->where('ended', '=', 0)
                        ->orderBy('created_at', 'DESC')
                        ->latest()->get();
                    $data = $trips;
                }

                if (count($data) > 0) {
                    return self::returnResponseDataApi(TripResource::collection($data), 'تم الحصول علي جميع بيانات الرحلات بنجاح', 200, 200);
                } else {
                    return self::returnResponseDataApi($data, 'عفوا لا يوجد رحلات حاليا', 200, 200);
                }
            } else {
                return self::returnResponseDataApi(null, 'يرجي ادخال النوع', 422, 422);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // user all trip

    public
    function favouriteLocations(): JsonResponse
    {
        try {
            $data = AddressFavorite::query()
                ->where('user_id', '=', Auth::user()->id)
                ->latest()->get();
            if (count($data) > 0) {
                return self::returnResponseDataApi($data, 'تم الحصول علي جميع بيانات الموقع المفضلة بنجاح', 200, 200);
            } else {
                return self::returnResponseDataApi($data, 'لا يوجد مواقع مفضلة حالية', 200, 200);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // favouriteLocations

    public
    function createFavouriteLocations(Request $request): JsonResponse
    {
        try {
            $rules = [
                'address' => 'required',
                'lat' => 'required',
                'long' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                return self::returnResponseDataApi(null, $firstError, 422);
            }

            $address = AddressFavorite::query()
                ->updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'address' => $request->address,
                ], [
                    'user_id' => Auth::user()->id,
                    'address' => $request->address,
                    'lat' => $request->lat,
                    'long' => $request->long,
                ]);

            if (isset($address)) {
                return self::returnResponseDataApi($address, "تم اضافة الموقع في المفضلة بنجاح", 201, 200);
            } else {
                return self::returnResponseDataApi(null, "يوجد خطاء ما اثناء دخول البيانات", false, 500);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // favouriteLocations

    public
    function removeFavouriteLocations(Request $request): JsonResponse
    {
        try {
            $rules = [
                'address_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                return self::returnResponseDataApi(null, $firstError, 422);
            }

            $address = AddressFavorite::query()
                ->find($request->address_id);

            if ($address) {
                $address->delete();
                return self::returnResponseDataApi(null, "تم حذف الموقع من المفضلة بنجاح", 200, 200);
            } else {
                return self::returnResponseDataApi(null, "لا يوجد موقع في المفضلة بهذا المعرف", 404, 404);
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } // favouriteLocations

    public
    function getAllSettings(): JsonResponse
    {
        $settings = Setting::first();
        return self::returnResponseDataApi(new SettingResource($settings), "تم الحصول علي بيانات جميع الاعدادت بنجاح", 200);
    } //getAllSettings

    public
    function getAllNotification(): JsonResponse
    {
        $user = Auth::user();
        if ($user->type == 'user') {
            $notifications = Notification::query()
                ->where('user_id', '=', $user->id)
                ->OrWhereIn('type', ['all', 'all_user'])
                ->get();
        } elseif ($user->type == 'driver') {
            $notifications = Notification::query()
                ->where('user_id', '=', $user->id)
                ->OrWhereIn('type', ['all', 'all_driver'])
                ->get();
        }


        if ($notifications->isEmpty()) {
            return self::returnResponseDataApi([], "لا يوجد إشعارات لهذا المستخدم", 200);
        }
        return self::returnResponseDataApi($notifications, "تم الحصول على الإشعارات بنجاح", 200);
    } //getAllNotification

    public
    function deleteUser(): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        if (!$user) {
            return self::returnResponseDataApi([], "لا يوجد حساب المستخدم", 200);
        }
        $user->delete();
        return self::returnResponseDataApi($user, "تم حذف الحساب بنجاح", 200);
    } //deleteUser

    public
    function createTripRate(Request $request): JsonResponse
    {
        try {
            $rules = [
                'trip_id' => 'required',
                'rate' => 'required',
                'description' => 'nullable',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $firstError = $validator->errors()->first();
                return self::returnResponseDataApi(null, $firstError, 422, 422);
            }

            $checkTrip = Trip::query()
                ->where('id', $request->trip_id)->first();

            if ($checkTrip) {
                if ($checkTrip->type == 'complete') {
                    $existingTripRate = TripRates::where('trip_id', $request->trip_id)
                        ->where('from', Auth::user()->id)
                        ->first();
                    if ($existingTripRate) {
                        return self::returnResponseDataApi(null, "تم تقييم الرحلة بالفعل", 500, 200);
                    }
                } else {
                    return self::returnResponseDataApi(null, "تاكد من حالة الرحلة انها مكتملة", 500, 200);
                }

                $createTripRate = TripRates::query()
                    ->create([
                        'trip_id' => $request->trip_id,
                        'from' => Auth::user()->id,
                        'to' => $checkTrip->driver_id,
                        'rate' => $request->rate,
                        'description' => $request->description,
                    ]);

                if (isset($createTripRate)) {
                    return self::returnResponseDataApi(new TripRateResource($createTripRate), "تم انشاء التقييم بنجاح", 201);
                } else {
                    return self::returnResponseDataApi(null, "يوجد خطاء ما أثناء دخول البيانات", false, 500);
                }

            } else {
                return self::returnResponseDataApi(null, "تاكد من معرف الرحلة ", 500, 500);
            }

        } catch (\Exception $exception) {
            return self::returnResponseDataApi($exception->getMessage(), 500, false, 500);
        }
    } //createTripRate
}
