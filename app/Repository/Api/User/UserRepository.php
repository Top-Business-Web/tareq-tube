<?php

namespace App\Repository\Api\User;

use App\Http\Resources\InviteFriendResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ModelPriceResource;
use App\Http\Resources\MyTubeResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TubeResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\City;
use App\Models\ConfigCount;
use App\Models\DeviceToken;
use App\Models\Interest;
use App\Models\InviteToken;
use App\Models\Message;
use App\Models\ModelPrice;
use App\Models\Notification;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tube;
use App\Models\User;
use App\Repository\Api\ResponseApi;
use App\Traits\FirebaseNotification;
use App\Traits\PhotoTrait;
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

                $check_exists->name = $request->name;
                $check_exists->image = $request->image;
                $check_exists->save();


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
                $createUser->gmail = $request->gmail;
                $createUser->image = $request->image;
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

                    InviteToken::query()->create([
                        'token' => self::randomToken(10),
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
        try {
            $interests = Interest::select('id', 'name')->get();
            return self::returnResponseDataApi($interests, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    public function getCities(): JsonResponse
    {
        try {
            $cities = City::select('id', 'name')->get();
            return self::returnResponseDataApi($cities, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    public function setting(): JsonResponse
    {
        try {
            $data = Setting::first();
            return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    public function getHome(): JsonResponse
    {

        try {
            $subscribe_count = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'sub')
                ->count();
            $views_count = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'view')
                ->count();
            $message_count = Message::query()->where('user_id', Auth::guard('user-api')->user()->id)->count();
            $data = [
                'sliders' => SliderResource::collection(Slider::get()),
                'user' => new UserResource(\Auth::user()),
                'subscribe_count' => $subscribe_count,
                'views_count' => $views_count,
                'message_count' => $message_count,
            ];
            return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // get HomePage

    public function configCount(Request $request): JsonResponse
    {
        try {
            $data = ConfigCount::query()
                ->when($request->type, function ($query, $type) {
                    return $query->where('type', $type);
                })
                ->select('id', 'type', 'count', 'point')
                ->get();
            return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    public function addTube(Request $request): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            $userPoint = $user->points;

            $validator = Validator::make($request->all(), [
                'type' => 'required|in:sub,view',
                'url' => 'required|url',
                'sub_count' => 'required_if:type,sub',
                'view_count' => 'required_if:type,view',
                'second_count' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $sub_count = 0;
            $view_count = 0;
            if ($request->has('sub_count') && $request->sub_count != '') {
                $sub_count = ConfigCount::find($request->sub_count)->point;
            }
            if ($request->has('view_count') && $request->view_count != '') {
                $view_count = ConfigCount::find($request->view_count)->point;
            }
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

                        return self::returnResponseDataApi(new TubeResource($createTube), 'تم الانشاء بنجاح', 201);
                    } else {
                        return self::returnResponseDataApi(null, 'هناك خطا ما', 500);
                    }
                } else {
                    return self::returnResponseDataApi(null, 'نقاطك لا تكفي لاتمام العملية تحتاج الي ' . $pointsNeed - $userPoint . ' من النقاط ', 422);
                }
            } else {
                return self::returnResponseDataApi(null, 'تم الانتهاء من الباقة الحالية قم بشراء باقة جديدة', 422);
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // add subscribe

    public function addMessage(Request $request): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();

            $validator = Validator::make($request->all(), [
                'url' => 'required|url',
                'description' => 'required',
                'city_id' => 'required',
                'intrest_id' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            if ($user->msg_limit > 0) {
                $addMessage = new Message();
                $addMessage->url = $request->url;
                $addMessage->user_id = Auth::guard('user-api')->user()->id;
                $addMessage->content = $request->description;
                $addMessage->city_id = $request->city_id;
                $addMessage->intrest_id = $request->intrest_id;

                if ($addMessage->save()) {
                    $user->msg_limit -= 1;
                    $user->save();
                    return self::returnResponseDataApi(new MessageResource($addMessage), 'تم انشاء الرسالة بنجاح', 201);
                } else {
                    return self::returnResponseDataApi(null, 'هناك خطا ما', 500);
                }
            } else {
                return self::returnResponseDataApi(null, 'لا يوجد باقة رسائل لديك  قم بشراء باقة رسائل', 422);
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end add Message

    public function notification(): JsonResponse
    {
        try {
            $data = Notification::query()->where('user_id', Auth::user()->id)
                ->orWhere('user_id', null)->get();

            return self::returnResponseDataApi(NotificationResource::collection($data), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end notification

    public function mySubscribe(): JsonResponse
    {
        try {
            $tubes = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'sub')
                ->get();
            return self::returnResponseDataApi(MyTubeResource::collection($tubes), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my subscribe

    public function myViews(): JsonResponse
    {
        try {
            $tubes = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'view')
                ->get();

            return self::returnResponseDataApi(MyTubeResource::collection($tubes), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my views

    public function myProfile(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            return self::returnResponseDataApi(new UserResource($user), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my profile

    public function addChannel(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::guard('user-api')->user()->id);
            $validator = Validator::make($request->all(), [
                'youtube_link' => 'required|active_url|url',
                'youtube_name' => 'required',
                'youtube_image' => 'required|active_url|url',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $user->youtube_link = $request->youtube_link;
            $user->youtube_name = $request->youtube_name;
            $user->youtube_image = $request->youtube_image;
            if ($user->save()) {
                return self::returnResponseDataApi(new UserResource($user), 'تم اضافة لينك القناة بنجاح');
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // add channel

    public function getPageCoinsOrMsg(Request $request): JsonResponse
    {
        try {
            $type = $request->type;
            $listPoint = ModelPrice::where('type', $type)
                ->orderBy('count', 'asc')
                ->get();
            return self::returnResponseDataApi(ModelPriceResource::collection($listPoint), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    public function getLinkInvite(): JsonResponse
    {
        try {
            $user = Auth::user()->points;
            $tokenPrice = Setting::query()->value('token_price');
            $token = InviteToken::query()->value('token');
            return self::returnResponseDataApi(new InviteFriendResource(['user' => $user, 'tokenPrice' => $tokenPrice, 'token' => $token]), 'تم الحصول على البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    public function getVipList(): JsonResponse
    {
        try {
            $packages = Package::query()->select('id', 'name', 'price', 'days')
                ->orderBy('days')
                ->get();
            return self::returnResponseDataApi(PackageResource::collection($packages), 'تم الحصول على البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }
}
