<?php

namespace App\Repository\Api\User;

use App\Http\Resources\SliderResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\City;
use App\Models\ConfigCount;
use App\Models\DeviceToken;
use App\Models\Interest;
use App\Models\InviteToken;
use App\Models\Message;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tube;
use App\Models\User;
use App\Repository\Api\ResponseApi;
use App\Traits\FirebaseNotification;
use App\Traits\PhotoTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository extends ResponseApi implements UserRepositoryInterface
{
    use PhotoTrait, FirebaseNotification;

    public function loginWithGoogle(Request $request): JsonResponse
    {
        try {

            $setting = Setting::first();

            // Validation Rules
            $validatorLogin = Validator::make($request->all(), [
                'gmail' => 'required|email'
            ]);

            if ($validatorLogin->fails()) {
                $errors = $validatorLogin->errors()->first();
                return self::returnResponseDataApi(null, $errors, 422);
            }

            $check_exists = User::where('gmail', '=', $request->gmail)->first();

            if ($check_exists) {
                // Authenticate User
                $credentials = ['gmail' => $request->gmail, 'password' => '123456'];
                $token = Auth::guard('user-api')->attempt($credentials);

                // Get User and Attach Token
                $user = Auth::guard('user-api')->user();
                $user['token'] = $token;


                // Update or Create PhoneToken
                DeviceToken::query()->updateOrCreate(
                    ['user_id' => $user->id, 'type' => $request->device_type],
                    ['type' => $request->device_type, 'token' => $request->token]
                );

                return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200);

            } else {

                // Validation Rules
                $validatorRegister = Validator::make($request->all(), [
                    'gmail' => 'required|email',
                    'intrest_id' => 'required',
                ]);

                // Check Validation Result
                if ($validatorRegister->fails()) {
                    $errors = $validatorRegister->errors()->first();
                    return self::returnResponseDataApi(null, $errors, 422);
                }

                // create user
                $createUser = new User();
                $createUser->name = $request->name ?? 'User';
                $createUser->image = $request->image ?? null;
                $createUser->gmail = $request->gmail;
                $createUser->password = Hash::make('123456');
                $createUser->google_id = $request->google_id ?? null;
                $createUser->intrest_id = $request->intrest_id;
                $createUser->points = $setting->point_user ?? 0;
                $createUser->limit = $setting->limit_user ?? 0;
                $createUser->msg_limit = 0;
                $createUser->youtube_link = $request->youtube_link ?? null;

                if ($createUser->save()) {
                    // Authenticate User
                    $credentials = ['gmail' => $createUser->gmail, 'password' => '123456'];
                    $token = Auth::guard('user-api')->attempt($credentials);

                    // Get User and Attach Token
                    $createUser = Auth::guard('user-api')->user();
                    $createUser['token'] = $token;

                    // Update or Create PhoneToken
                    DeviceToken::query()->updateOrCreate(
                        ['user_id' => $createUser->id, 'type' => $request->device_type],
                        ['type' => $request->device_type, 'token' => $request->token]
                    );

                    InviteToken::create([
                        'token' => self::randomToken(60),
                        'from_user_id' => $createUser->id,
                        'status' => 0
                    ]);

                    return self::returnResponseDataApi(new UserResource($createUser), 'تم تسجيل الدخول لاول مرة بنجاح', 201);
                } else {
                    return self::returnResponseDataApi(new UserResource($createUser), 'هناك خطا ما حاول في وقت لاحق', 422);
                }
            }

        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }

    } // end login with Google

    public function logout(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();

            DeviceToken::query()
                ->where('user_id', $user->id)
                ->where('token', '=', $user->device->token)
                ->delete();

            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    } // logout

    public function deleteAccount(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            DeviceToken::query()->where('user_id', $user->id)->delete();
            InviteToken::query()->where('from_user_id', $user->id)->first()->delete();


            $user->delete();
            Auth::guard('user-api')->logout();

            return self::returnResponseDataApi(null, "تم حذف الحساب بنجاح وتم تسجيل الخروج من التطبيق", 200);
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    } // deleteAccount

    public function getInterests(): JsonResponse
    {
        $interests = Interest::select('id', 'name')->get();
        return self::returnResponseDataApi($interests, 'تم الحصول علي البيانات بنجاح');
    } // getInterest

    public function getCities(): JsonResponse
    {
        $cities = City::select('id', 'name')->get();
        return self::returnResponseDataApi($cities, 'تم الحصول علي البيانات بنجاح');
    } // getInterest

    public function getHome(): JsonResponse
    {
        $subscribe_count = Tube::where('user_id', Auth::user()->id)
            ->where('type', 'sub')
            ->count();
        $views_count = Tube::where('user_id', Auth::user()->id)
            ->where('type', 'view')
            ->count();
        $message_count = Message::where('user_id', Auth::user()->id)->count();
        $data = [
            'sliders' => SliderResource::collection(Slider::get()),
            'user' => new UserResource(\Auth::user()),
            'subscribe_count' => $subscribe_count,
            'views_count' => $views_count,
            'message_count' => $message_count,
        ];
        return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
    } // get HomePage

    public function configCount(Request $request): JsonResponse
    {
        $data = ConfigCount::query()
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->select('id', 'type', 'count', 'point')
            ->get();
        return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
    }

    public function addTube(Request $request): JsonResponse
    {
        $user = Auth::user();
        $setting = Setting::first();
        $limit = $user->limit;
        $userPoint = $user->points;

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:sub,view',
            'url' => 'required|url',
            'sub_count' => 'required_if:type,sub',
            'view_count' => 'required',
            'second_count' => 'required',
        ]);

        if ($validator->fails()){
            $error = $validator->errors()->first();
            return self::returnResponseDataApi(null,$error,422);
        }

        $sub_count = 0;
        if ($request->has('sub_count') && $request->sub_count != '') {
            $sub_count = ConfigCount::find($request->sub_count)->point;
        }
        $view_count = ConfigCount::find($request->view_count)->point;
        $second_count = ConfigCount::find($request->second_count)->point;
        $pointsNeed = $second_count + $view_count + $sub_count;

        if ($user->limit > 0) {
            if ($userPoint >= $pointsNeed) {
                $createTube = new Tube();
                $createTube->type = $request->type;
                $createTube->points = $pointsNeed;
                $createTube->user_id = $user->id;
                $createTube->url = $request->url;
                $createTube->sub_count = $request->sub_count;
                $createTube->second_count = $request->second_count;
                $createTube->view_count = $request->view_count;
                $createTube->target = 0;
                $createTube->status = 0;

                if ($createTube->save()) {
                    $user->points -= $pointsNeed;
                    $user->limit -= 1;
                    $user->save();

                    return self::returnResponseDataApi($createTube, 'تم الانشاء بنجاح', 201);
                } else {
                    return self::returnResponseDataApi(null, 'هناك خطا ما', 500);

                }


            } else {
                return self::returnResponseDataApi(null, 'نقاطك لا تكفي لاتمام العملية تحتاج الي ' . $pointsNeed - $userPoint . ' من النقاط ', 422);
            }
        } else {
            return self::returnResponseDataApi(null, 'تم الانتهاء من الباقة الحالية قم بشراء باقة جديدة', 422);
        }

    } // add subscribe
}
