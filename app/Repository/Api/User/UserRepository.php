<?php

namespace App\Repository\Api\User;

use App\Http\Resources\InviteFriendResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ModelPriceResource;
use App\Http\Resources\MyMessageResource;
use App\Http\Resources\MyTubeResource;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\PackageResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TubeResource;
use App\Http\Resources\UserResource;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\City;
use App\Models\ConfigCount;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\DeviceToken;
use App\Models\GoogleDeviceId;
use App\Models\Interest;
use App\Models\InviteToken;
use App\Models\Message;
use App\Models\ModelPrice;
use App\Models\Notification;
use App\Models\Package;
use App\Models\RewardBox;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Tube;
use App\Models\User;
use App\Models\UserAction;
use App\Models\UserSpin;
use App\Models\Withdraw;
use App\Repository\Api\ResponseApi;
use App\Traits\FirebaseNotification;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;


class UserRepository extends ResponseApi implements UserRepositoryInterface
{
    use PhotoTrait, FirebaseNotification;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loginWithGoogle(Request $request): JsonResponse
    {
        try {

            $setting = Setting::first();

            // Validation Rules
            $validatorLogin = Validator::make($request->all(), [
                'gmail' => 'required|email',
                'device_id' => 'required',
                'access_token' => 'required'
            ]);

            if ($validatorLogin->fails()) {
                $errors = $validatorLogin->errors()->first();
                return self::returnResponseDataApi(null, $errors, 422);
            }

            $check_exists = User::where('gmail', '=', $request->gmail)->first();

            if ($check_exists) {

                $check_exists->name = $request->name;
                $check_exists->image = $request->image;
                $check_exists->access_token = $request->access_token;
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

                // check if the user device id equals the current gmail
                $checkDeviceId = GoogleDeviceId::query()
                    ->where(['gmail' => $check_exists->gmail, 'device_id' => $request->device_id])->first();

                if (!$checkDeviceId) {
                    return self::returnResponseDataApi(null, "معرف الجهاز غير متطابق مع الجيميل الخاص بك", 422);
                } // end if

                return self::returnResponseDataApi(new UserResource($user), "تم تسجيل الدخول بنجاح", 200);
            } else {

                // Validation Rules
                $validatorRegister = Validator::make($request->all(), [
                    'gmail' => 'required|email',
                    'intrest_id' => 'required',
                    'access_token' => 'required',
                    'device_id' => 'required|unique:google_device_ids,device_id,except,id'
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
                $createUser->invite_token = self::randomToken(10);
                $createUser->access_token = $request->access_token;

                if ($createUser->save()) {
                    // Authenticate User
                    $credentials = ['gmail' => $createUser->gmail, 'password' => '123456'];
                    $token = Auth::guard('user-api')->attempt($credentials);

                    //? Get User and Attach Token
                    $createUser = Auth::guard('user-api')->user();
                    $createUser['token'] = $token;

                    //? Update or Create PhoneToken
                    DeviceToken::query()->updateOrCreate(
                        ['user_id' => $createUser->id, 'type' => $request->device_type],
                        ['type' => $request->device_type, 'token' => $request->token]
                    );
                    //? create a new user device Id with gmail
                    new GoogleDeviceId($request->device_id, $request->gmail);

                    return self::returnResponseDataApi(new UserResource($createUser), 'تم تسجيل الدخول لاول مرة بنجاح', 201);
                } else {
                    return self::returnResponseDataApi(new UserResource($createUser), 'هناك خطا ما حاول في وقت لاحق', 422);
                }
            }
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    } // end login with Google

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();

            return self::returnResponseDataApi(null, "تم تسجيل الخروج بنجاح", 200);
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    } // logout

    /**
     * @return JsonResponse
     */
    public function deleteAccount(): JsonResponse
    {
        try {
            /** @var \App\Models\User $user * */
            $user = Auth::guard('user-api')->user();
            DeviceToken::query()->where('user_id', $user->id)->delete();
            //            Tube::query()->where('user_id', $user->id)->delete();
            //            UserAction::query()->where('user_id', $user->id)->delete();
            $user->delete();
            Auth::guard('user-api')->logout();

            return self::returnResponseDataApi(null, "تم حذف الحساب بنجاح وتم تسجيل الخروج من التطبيق", 200);
        } catch (\Exception $exception) {
            return self::returnResponseDataApi(null, $exception->getMessage(), 500);
        }
    } // deleteAccount

    /**
     * @return JsonResponse
     */
    public function getInterests(): JsonResponse
    {
        try {
            $interests = Interest::select('id', 'name')->get();
            return self::returnResponseDataApi($interests, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    /**
     * @return JsonResponse
     */
    public function getCities(): JsonResponse
    {
        try {
            $cities = City::select('id', 'name')->get();
            return self::returnResponseDataApi($cities, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    /**
     * @return JsonResponse
     */
    public function setting(): JsonResponse
    {
        try {
            $data = Setting::first();
            $data = self::withoutTimeStamp($data);
            return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getInterest

    /**
     * @return JsonResponse
     */
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

            $setting = Setting::query()->first([
                'phone',
                'limit_user',
                'point_user',
                'vat',
                'point_price',
                'limit_balance',
                'token_price',
                'config_box_minute',
                'config_box_min',
                'config_box_max',
                'ad_click_photo',
                'ad_click_video'
            ]);

            $data = [
                'sliders' => SliderResource::collection(Slider::get()),
                'user' => new UserResource(\Auth::user()),
                'subscribe_count' => $subscribe_count,
                'views_count' => $views_count,
                'message_count' => $message_count,
                'setting' => $setting,
            ];
            return self::returnResponseDataApi($data, 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // get HomePage

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTube(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::guard('user-api')->user()->id);
            $userPoint = $user->points;

            $validator = Validator::make($request->all(), [
                'type' => 'required|in:sub,view,app',
                'url' => 'required|url',
                'sub_count' => 'required_if:type,sub',
                'view_count' => 'required_if:type,view',
                'app_count' => 'required_if:type,app',
                'second_count' => 'required_if:type,view',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $sub_count = 0;
            $view_count = 0;
            $app_count = 0;
            if ($request->has('second_count') && $request->second_count != '') {
                $second_count = ConfigCount::find($request->second_count)->point;
            }
            // if tube request Channel Subscription
            if ($request->has('sub_count') && $request->sub_count != '') {
                $sub_count = ConfigCount::find($request->sub_count)->point;
                $sub_count_count = ConfigCount::find($request->sub_count)->count;
                $pointsNeed = $second_count * $sub_count;
            }

            // if tube request Videos Views
            if ($request->has('view_count') && $request->view_count != '') {
                $view_count = ConfigCount::find($request->view_count)->point;
                $view_count_count = ConfigCount::find($request->view_count)->count;
                $pointsNeed = $second_count * $view_count;
            }

            // if tube request Download Applications
            if ($request->has('app_count') && $request->app_count != '') {
                $app_count = ConfigCount::find($request->app_count)->point;
                $app_count_count = ConfigCount::find($request->app_count)->count;
                $pointsNeed = $app_count;
            }

            // if user not have VIP Package
            if ($user->is_vip != 1) {
                if ($user->limit > 0) {
                    if ($userPoint >= $pointsNeed) {
                        $createTube = new Tube();
                        $createTube->type = $request->type;
                        $createTube->points = $pointsNeed;
                        $createTube->user_id = $user->id;
                        $createTube->url = $request->url;
                        $createTube->sub_count = $request->type == 'view' ? null : $request->sub_count;
                        $createTube->second_count = $request->second_count;
                        $createTube->view_count = $request->view_count;
                        $createTube->app_count = $request->app_count;
                        if ($request->type == 'view')
                            $createTube->target = $view_count_count;
                        elseif ($request->type == 'sub')
                            $createTube->target = $sub_count_count;
                        else
                            $createTube->target = $app_count_count;

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
            } else {
                // if user have VIP Package
                if ($userPoint >= $pointsNeed) {
                    $createTube = new Tube();
                    $createTube->type = $request->type;
                    $createTube->points = $pointsNeed;
                    $createTube->user_id = $user->id;
                    $createTube->url = $request->url;
                    $createTube->sub_count = $request->type == 'view' ? null : $request->sub_count;
                    $createTube->second_count = $request->second_count;
                    $createTube->view_count = $request->view_count;
                    $createTube->app_count = $request->app_count;
                    if ($request->type == 'view')
                        $createTube->target = $view_count_count;
                    elseif ($request->type == 'sub')
                        $createTube->target = $sub_count_count;
                    else
                        $createTube->target = $app_count_count;
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
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // add user tubes


    public function addApp(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::guard('user-api')->user()->id);
            $userPoint = $user->points;

            $validator = Validator::make($request->all(), [
                'type' => 'required|in:sub,view,app',
                'url' => 'required|url',
                'sub_count' => 'required_if:type,sub',
                'view_count' => 'required_if:type,view',
                'app_count' => 'required_if:type,app',
                'second_count' => 'required_if:type,view',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $sub_count = 0;
            $view_count = 0;
            $app_count = 0;
            if ($request->has('second_count') && $request->second_count != '') {
                $second_count = ConfigCount::find($request->second_count)->point;
            }
            // if tube request Channel Subscription
            if ($request->has('sub_count') && $request->sub_count != '') {
                $sub_count = ConfigCount::find($request->sub_count)->point;
                $sub_count_count = ConfigCount::find($request->sub_count)->count;
                $pointsNeed = $second_count * $sub_count;
            }

            // if tube request Videos Views
            if ($request->has('view_count') && $request->view_count != '') {
                $view_count = ConfigCount::find($request->view_count)->point;
                $view_count_count = ConfigCount::find($request->view_count)->count;
                $pointsNeed = $second_count * $view_count;
            }

            // if tube request Download Applications
            if ($request->has('app_count') && $request->app_count != '') {
                $app_count = ConfigCount::find($request->app_count)->point;
                $app_count_count = ConfigCount::find($request->app_count)->count;
                $pointsNeed = $app_count;
            }

            // if user not have VIP Package
            if ($user->is_vip != 1) {
                if ($user->limit > 0) {
                    if ($userPoint >= $pointsNeed) {
                        $createTube = new Tube();
                        $createTube->type = $request->type;
                        $createTube->points = $pointsNeed;
                        $createTube->user_id = $user->id;
                        $createTube->url = $request->url;
                        $createTube->sub_count = $request->type == 'view' ? null : $request->sub_count;
                        $createTube->second_count = $request->second_count;
                        $createTube->view_count = $request->view_count;
                        $createTube->app_count = $request->app_count;
                        if ($request->type == 'view')
                            $createTube->target = $view_count_count;
                        elseif ($request->type == 'sub')
                            $createTube->target = $sub_count_count;
                        else
                            $createTube->target = $app_count_count;

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
            } else {
                // if user have VIP Package
                if ($userPoint >= $pointsNeed) {
                    $createTube = new Tube();
                    $createTube->type = $request->type;
                    $createTube->points = $pointsNeed;
                    $createTube->user_id = $user->id;
                    $createTube->url = $request->url;
                    $createTube->sub_count = $request->type == 'view' ? null : $request->sub_count;
                    $createTube->second_count = $request->second_count;
                    $createTube->view_count = $request->view_count;
                    $createTube->app_count = $request->app_count;
                    if ($request->type == 'view')
                        $createTube->target = $view_count_count;
                    elseif ($request->type == 'sub')
                        $createTube->target = $sub_count_count;
                    else
                        $createTube->target = $app_count_count;
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
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // add user tubes


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addMessage(Request $request): JsonResponse
    {
        try {
            /** @var \App\Models\User $user * */
            $user = Auth::guard('user-api')->user();

            $validator = Validator::make($request->all(), [
                'url' => 'required|url',
                'description' => 'required',
                'city_id' => 'required',
                'intrest_id' => 'required',
            ]);
            //|> Validator Fails
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

                    //|> send FCM notification
                    $fcmData = [
                        'title' => 'رسالة جديدة',
                        'body' => $addMessage->content
                    ];
                    self::sendFcm($fcmData['title'], $fcmData['body'], null, true, $addMessage->intrest_id);

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

    /**
     * @return JsonResponse
     */
    public function notification(): JsonResponse
    {
        try {
            $data = Notification::query()->where('user_id', Auth::user()->id)
                ->orWhere('user_id', null)
                ->latest()
                ->get();

            return self::returnResponseDataApi(NotificationResource::collection($data), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end notification

    /**
     * @return JsonResponse
     */
    public function mySubscribe(): JsonResponse
    {
        try {
            $tubes = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', '=', 'sub')
                ->latest()
                ->get();
            return self::returnResponseDataApi(MyTubeResource::collection($tubes), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my subscribe

    /**
     * @return JsonResponse
     */
    public function myViews(): JsonResponse
    {
        try {
            $tubes = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'view')
                ->latest()
                ->get();

            return self::returnResponseDataApi(MyTubeResource::collection($tubes), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my views

    /**
     * @return JsonResponse
     */
    public function myProfile(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            return self::returnResponseDataApi(new UserResource($user), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my profile

    /**
     * @return JsonResponse
     */
    public function myMessages(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            $messages = Message::query()->where('user_id', $user->id)->latest()->get();
            if ($messages->count() > 0) {
                return self::returnResponseDataApi(MyMessageResource::collection($messages), 'تم الحصول علي البيانات بنجاح');
            } else {
                return self::returnResponseDataApi([], 'تم الحصول علي البيانات بنجاح');
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function myDownloads(): JsonResponse
    {
        try {
            $tubes = Tube::query()->where('user_id', Auth::guard('user-api')->user()->id)
                ->where('type', 'app')
                ->latest()
                ->get();

            return self::returnResponseDataApi(MyTubeResource::collection($tubes), 'تم الحصول علي البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // my downloads

    /**
     * @return JsonResponse
     */
    public function getMessages(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            $messages = Message::query()
                ->where('intrest_id', $user->intrest_id)
                ->latest()
                ->get();
            if ($messages->count() > 0) {
                return self::returnResponseDataApi(MessageResource::collection($messages), 'تم الحصول علي البيانات بنجاح');
            } else {
                return self::returnResponseDataApi(null, 'لا يوجد رسائل حتي الان', 422);
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addChannel(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::guard('user-api')->user()->id);
            $validator = Validator::make($request->all(), [
                'youtube_link' => 'required|active_url|url',
                'youtube_name' => 'required',
                'youtube_image' => 'required|active_url|url',
                'channel_name' => 'required',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $user->youtube_link = $request->youtube_link;
            $user->youtube_name = $request->youtube_name;
            $user->youtube_image = $request->youtube_image;
            $user->channel_name = $request->channel_name;
            if ($user->save()) {
                return self::returnResponseDataApi(new UserResource($user), 'تم اضافة لينك القناة بنجاح');
            } else {
                return self::returnResponseDataApi(null, 'هناك خطا ما', 500);
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // add channel

    /**
     * @param Request $request
     * @return JsonResponse
     */
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
    } //  getPageCoinsOrMsg

    /**
     * @return JsonResponse
     */
    public function getLinkInvite(): JsonResponse
    {
        try {
            $token = Auth::user()->invite_token;
            return self::returnResponseDataApi(['token' => $token], 'تم الحصول على البيانات بنجاح');
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // getLinkInvite

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function AddLinkPoints(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);

            $tokenPrice = Setting::query()->value('token_price');
            $checkToken = User::query()->where('invite_token', $request->token)
                ->where('id', '!=', $user->id)
                ->first();

            if (!$checkToken) {
                return self::returnResponseDataApi(null, 'الكود غير موجود', 422);
            } else {
                $fromUser = $checkToken;
                $checkInviteLink = InviteToken::query()->where('user_id', $user->id)
                    ->where('token', $request->token)->first();

                if ($checkInviteLink) {
                    return self::returnResponseDataApi(null, 'تم استخدام الكود من قبل', 422);
                } else {
                    $createInviteLink = new InviteToken();
                    $createInviteLink->token = $request->token;
                    $createInviteLink->user_id = $user->id;
                    $createInviteLink->status = 1;
                    $createInviteLink->save();

                    $fromUser->points += $tokenPrice;
                    $fromUser->save();
                    $user->points += $tokenPrice;
                    $user->save();
                    self::sendFcm('مكافئة التنزيل', 'تم اضافة مكافئة التنزيل رصيدك اصبح : ' . $fromUser->points, $fromUser->id);
                    self::sendFcm('مكافئة التنزيل', 'تم اضافة مكافئة التنزيل رصيدك اصبح : ' . $user->points, $user->id);
                    return self::returnResponseDataApi(new UserResource($user), 'تم اضافة النقاط بنجاح');
                }
            }
        } catch (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // AddLinkPoints

    /**
     * @return JsonResponse
     */
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
    }  // getVipList

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPointSpin(Request $request): JsonResponse
    {
        try {

            if (!$this->checkPointSpinPool()) {
                return self::returnResponseDataApi(['status' => 0], 'عجلة الحظ غير متاحة', 200);
            }
            $validator = Validator::make($request->all(), [
                'points' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $user = User::find(Auth::user()->id);

            $spin = new UserSpin();
            $spin->user_id = $user->id;
            $spin->points = $request->points;
            $spin->day = Carbon::now()->format('Y-m-d');

            if ($spin->save()) {
                $user->points += $request->points;
                if ($user->save()) {
                    return self::returnResponseDataApi(new UserResource($user), 'تم اضافة النقاط بنجاح', 200);
                } else {
                    return self::returnResponseDataApi(null, 'هناك خطا ما حاول في وقت لاحق', 500);
                }
            } else {
                return self::returnResponseDataApi(null, 'هناك خطا ما حاول في وقت لاحق', 500);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }  // addPointSpin

    /**
     * @return JsonResponse
     */
    public function checkPointSpin(): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);
            $checkSpin = UserSpin::query()
                ->where('user_id', $user->id)
                ->latest()
                ->first();
            if ($checkSpin) {
                $oldDay = Carbon::parse($checkSpin->created_at)->addDay();
                $checkDay = $oldDay < Carbon::now();
                if ($checkDay) {
                    return self::returnResponseDataApi(['status' => 1], 'عجلة الحظ متاحة', 200);
                } else {
                    return self::returnResponseDataApi(['status' => 0], 'عجلة الحظ غير متاحة', 200);
                }
            } else {
                return self::returnResponseDataApi(['status' => 1], 'عجلة الحظ متاحة', 200);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // checkPointSpin

    /**
     * @return bool
     */
    public function checkPointSpinPool(): bool
    {

        $user = User::find(Auth::user()->id);
        $checkSpin = UserSpin::query()
            ->where('user_id', $user->id)
            ->latest()
            ->first();
        if ($checkSpin) {
            $oldDay = Carbon::parse($checkSpin->created_at)->addDay();
            $checkDay = $oldDay < Carbon::now();
            if ($checkDay) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } // checkPointSpinPool

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPointCopun(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);
            $validator = Validator::make($request->all(), [
                'copun' => 'required|exists:copons,code'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $copon = Coupon::query()->where('code', $request->copun)->first();

            if ($copon) {
                // user used coupons count
                $usersCoponCount = CouponUser::query()->where('copon_id', $copon->id)->count();
                // check if user used coupon
                $checkUserCopon = CouponUser::query()
                    ->where('copon_id', $copon->id)
                    ->where('user_id', $user->id)
                    ->first();
                if ($checkUserCopon) {
                    return self::returnResponseDataApi(null, 'تم استخدام هذا الكوبون من قبل', 422);
                }

                if ($usersCoponCount >= $copon->limit) {
                    return self::returnResponseDataApi(null, 'تم تخطي حد الاستخدام لهذا الكوبون', 422);
                }

                $createCouponUser = new CouponUser();
                $createCouponUser->user_id = $user->id;
                $createCouponUser->copon_id = $copon->id;
                $createCouponUser->save();

                $user->points += $copon->points;
                $user->save();
                return self::returnResponseDataApi(new UserResource($user), 'تم الحصول علي النقاط بنجاح', 200);
            } else {
                return self::returnResponseDataApi(null, 'الكوبون غير صحيح', 422);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } //

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTubeRandom(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:app',
                'per_page' => 'required|numeric',
                'current_page' => 'required|numeric'
            ], [
                'type.required' => 'حقل النوع مطلوب'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $userVideos = UserAction::query()
                ->where('user_id', $user->id)
                ->where('type', $request->type)
                ->where('status', '1')
                ->pluck('tube_id');

            $videosQuery = Tube::query()
                ->where('user_id', '!=', $user->id)
                ->whereNotIn('id', $userVideos)
                ->where('type', $request->type);

            // Paginate the query based on the parameters
            $videosPaginator = $videosQuery->paginate($request->per_page, ['*'], 'page', $request->current_page);

            // Get next page URL
            $nextPageUrl = $videosPaginator->nextPageUrl();

            // Custom pagination data
            $paginationData = [
                'total' => $videosPaginator->total(),
                'per_page' => $request->per_page,
                'current_page' => $videosPaginator->currentPage(),
                'last_page' => $videosPaginator->lastPage(),
                'next_page_url' => $nextPageUrl,
            ];

            // Create custom response data
            $responseData = [
                'data' => $videosPaginator->items(),
                'pagination' => $paginationData,
                'message' => 'تم الحصول على البيانات بنجاح',
                'code' => 200,
            ];

            return response()->json($responseData, 200);
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTubeViewAndSub(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);
            $validator = Validator::make($request->all(), [
                'type' => 'required|in:view,sub'
            ], [
                'type.required' => 'حقل النوع مطلوب'
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $userVideos = UserAction::query()
                ->where('user_id', $user->id)
                ->where('type', $request->type)
                ->where('status', '1')
                ->pluck('tube_id');

            $videos = Tube::query()
                ->where('user_id', '!=', $user->id)
                ->whereNotIn('id', $userVideos)
                ->where('type', $request->type)
                ->get();

            if ($videos->count() > 0) {
                $rundomVideos = $videos->random();
                return self::returnResponseDataApi($rundomVideos, 'تم الحصول على البيانات بنجاح', 200);
            } else {
                return self::returnResponseDataApi(null, 'لا يوجد بيانات', 200);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }



    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userViewTube(Request $request): JsonResponse
    {
        try {
            $vat = Setting::value('vat');
            $user = User::find(Auth::user()->id);
            // validate requests
            $validator = Validator::make($request->all(), [
                'tube_id' => 'required',
                'status' => 'required',
            ]);
            // return errors
            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            $tube = Tube::query()
                ->where('id', $request->tube_id)
                ->where('target', '!=', '0')
                ->first();

            if (!$tube) {
                return self::returnResponseDataApi(null, 'لا يوجد فيديو او قناه بهذا المعرف', 422);
            }
            // point vat calculate
            $point_vat = $tube->points - ($tube->points * ($vat / 100));

            // view point calculate
            if ($tube->type == 'view') {
                $point_gain = $point_vat / $tube->viewCount->count;
            } elseif ($tube->type == 'sub') {
                $point_gain = $point_vat / $tube->subCount->count;
            } else {
                $point_gain = $point_vat / $tube->appCount->count;
            }

            $point_gain = number_format($point_gain, 0);

            // check if action exists
            $checkActionExists = UserAction::query()
                ->where([
                    'user_id' => $user->id,
                    'tube_id' => $request->tube_id,
                ])->first();
            // if action update action exists status and point
            if ($checkActionExists) {

                if ($checkActionExists->status == 1) {
                    return self::returnResponseDataApi($checkActionExists, 'تم التحديث من قبل لا يمكن تغيير الحالة', 201);
                }

                $checkActionExists->update([
                    'status' => $request->status,
                    'points' => $point_gain
                ]);

                if ($checkActionExists->status == 1) {
                    $tube->target -= 1;
                    $tube->save();
                    $user->points += $point_gain;
                    $user->save();
                }

                return self::returnResponseDataApi($checkActionExists, 'تم التحديث بنجاح', 201);
            } else {
                $addUserAction = new UserAction();
                $addUserAction->user_id = $user->id;
                $addUserAction->tube_id = $request->tube_id;
                $addUserAction->type = $tube->type;
                $addUserAction->status = $request->status;
                $addUserAction->points = $point_gain;
                // if save return response
                if ($addUserAction->save()) {
                    if ($addUserAction->status == 1) {
                        $tube->target -= 1;
                        $tube->save();
                        $user->points += $point_gain;
                        $user->save();
                    }
                    return self::returnResponseDataApi($addUserAction, 'تم الاضافة بنجاح');
                } else {
                    return self::returnResponseDataApi(null, 'هناك خطا ما', 500);
                } // end if
            } // end if

        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        } // end try
    } // userViewTube

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUser(Request $request): JsonResponse
    {
        try {
            $gmail = $request->gmail;
            $checkUser = User::where('gmail', $gmail)->first();
            if ($checkUser) {
                return self::returnResponseDataApi(['status' => 1], 'هذا الحساب موجود في قواعد البيانات');
            } else {
                return self::returnResponseDataApi(['status' => 0], 'هذا الحساب غير موجود في قواعد البيانات');
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        } // end try
    } // checkUser


    /**
     ** check user device id for one device gmail account
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDevice(Request $request): JsonResponse
    {
        try {
            $data = [];
            $deviceId = GoogleDeviceId::query()
                ->select('device_id', 'gmail')
                ->where('device_id', $request->device_id)
                ->first();
            if ($deviceId) {
                $data['user'] = User::where('gmail', $deviceId->gmail)->first();
                $data['status'] = 1;
                return self::returnResponseDataApi($data, "تم الحصول علي البيانات بنجاح", 200);
            } else {
                $data['status'] = 0;
                return self::returnResponseDataApi($data, "لا يوجد بيانات مرتبطه بهذا المعرف", 200);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        } // end try
    } // checkDevice

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function withdraw(Request $request): JsonResponse
    {
        try {
            $user = User::find(Auth::user()->id);
            $point_price = Setting::value('point_price');
            $limit_balance = Setting::value('limit_balance');
            $rules = [
                'phone' => 'required',
                'amount' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return self::returnResponseDataApi(null, $error, 422);
            }

            if ($user->points < $limit_balance) {
                return self::returnResponseDataApi(null, 'لا يوجد رصيد كافي لسحبه اقل رصيد للسحب : ' . $limit_balance . ' ج.م', 422);
            }

            $createWithdraw = new Withdraw();
            $createWithdraw->user_id = $user->id;
            $createWithdraw->phone = $request->input('phone');
            $createWithdraw->price = $request->input('amount');
            $createWithdraw->status = 0;

            if ($createWithdraw->save()) {
                $user->points -= $createWithdraw->price * $point_price;
                $user->save();

                //|> send FCM notification
                $fcmData = [
                    'title' => 'طلب سحب رصيد',
                    'body' => 'تم طلب سحب رصيد وسيتم اخطارك بارسال الرصيد في اقرب وقت'
                ];
                $this->sendFirebaseNotification($fcmData, $user->id);

                return self::returnResponseDataApi(['status' => 1], 'تم ارسال طلب سحب رصيد بنجاح');
            } else {
                return self::returnResponseDataApi(null, 'هناك خطا ما حاول في وقت لاحق', 422);
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        } // end try
    } // end withdraw

    public function rewardBoxes(): JsonResponse
    {
        try {
            $user = Auth::guard('user-api')->user();
            $boxes = RewardBox::query()->get();
            foreach ($boxes as $box) {
                self::withoutTimeStamp($box);
            }
            if ($user->reward_box_id != null) {
                $user_box = User::where('id', $user->id)->select('reward_box_id')->first()->rewardBox;
                $box_open_time = Carbon::parse($user->reward_box_open);
                $yesterday = Carbon::now()->subDay();

                if ($box_open_time->diffInDays($yesterday) == 0 && $user_box->id != 7) {
                    foreach ($boxes as $box) {
                        if ($box->id <= $user_box->id) {
                            $box['opened'] = 1;
                        } else {
                            $box['opened'] = 0;
                        }

                        if ($box->id == $user_box->id + 1) {
                            $box['next'] = 1;
                        } else {
                            $box['next'] = 0;
                        }
                    }
                } elseif ($box_open_time->diffInDays($yesterday) == 0 && $user_box->id == 7) {
                    foreach ($boxes as $box) {
                        $box['opened'] = 0;
                        if ($box->id == 1) {
                            $box['next'] = 1;
                        } else {
                            $box['next'] = 0;
                        }
                    }
                } else {
                    foreach ($boxes as $box) {
                        $box['opened'] = 0;
                        if ($box->id == 1) {
                            $box['next'] = 1;
                        } else {
                            $box['next'] = 0;
                        }
                    }
                }

            } else {
                foreach ($boxes as $box) {
                    $box['opened'] = 0;
                    if ($box->id == 1) {
                        $box['next'] = 1;
                    } else {
                        $box['next'] = 0;
                    }
                }
            }

            return self::returnResponseDataApi($boxes, 'تم الحصول علي البيانات بنجاح');
        } catch
        (\Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end rewardBoxes

    public function openDailyBox(): JsonResponse
    {
        try {
            $user = User::find(Auth::guard('user-api')->user()->id);
            if ($user->reward_box_open == Carbon::now()->format('Y-m-d')) {
                return self::returnResponseDataApi(['status' => 0], 'تم فتح الصندوق اليومي بالفعل');
            }
            $old_box = $user->reward_box_id;

            $box_open_time = Carbon::parse($user->reward_box_open);
            $yesterday = Carbon::now()->subDay();
            if ($box_open_time->diffInDays($yesterday) == 0) {
                if ($old_box != 7) {
                    $user->reward_box_id = $old_box + 1;
                    $user->reward_box_open = Carbon::now();
                    if ($user->save()) {
                        $dailyPrize = RewardBox::query()->findOrFail($user->reward_box_id)->prize;
                        $user->points += $dailyPrize;
                        $user->save();
                        return self::returnResponseDataApi(['status' => 1], 'تم فتح الصندوق اليومي بنجاح');
                    } else {
                        return self::returnResponseDataApi(['status' => 0], 'هناك خطا ما', 422);
                    }
                } else {
                    $user->reward_box_id = 1;
                    $user->reward_box_open = Carbon::now();
                    if ($user->save()) {
                        $dailyPrize = RewardBox::query()->findOrFail($user->reward_box_id)->prize;
                        $user->points += $dailyPrize;
                        $user->save();
                        return self::returnResponseDataApi(['status' => 1], 'تم فتح الصندوق اليومي بنجاح');
                    } else {
                        return self::returnResponseDataApi(['status' => 0], 'هناك خطا ما', 422);
                    }
                }
            } else {
                $user->reward_box_id = 1;
                $user->reward_box_open = Carbon::now();
                if ($user->save()) {
                    $dailyPrize = RewardBox::query()->findOrFail($user->reward_box_id)->prize;
                    $user->points += $dailyPrize;
                    $user->save();
                    return self::returnResponseDataApi(['status' => 1], 'تم فتح الصندوق اليومي بنجاح');
                } else {
                    return self::returnResponseDataApi(['status' => 0], 'هناك خطا ما', 422);
                }
            }

        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    } // end openDailyBox

    public function addLuckyBoxPoints(Request $request): JsonResponse
    {
        try {
            $user = User::find(auth()->user()->id);

            $box_min = Setting::first()->value('config_box_min');
            $box_max = Setting::first()->value('config_box_max');
            $rand_points = rand($box_min, $box_max);
            $lucky_box_config = Setting::first()->value('config_box_minute');

            // condition check and open box
            if (Carbon::parse($user->box_open_time)->addMinutes($lucky_box_config)->format('Y-m-d H:i:s') < Carbon::now()->format('Y-m-d H:i:s')) {
                $user->box_open_time = Carbon::now()->format('Y-m-d H:i:s');
                $user->points += $rand_points;
                $user->save();
                return self::returnResponseDataApi(['status' => 1], 'تم فتح صندوق الحظ بنجاح');
            } else {
                return self::returnResponseDataApi(['status' => 0], 'تم فتح صندوق الحظ بالفعل');
            }

        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    public function openAdsWithPoints(): JsonResponse
    {
        try {
            $user = User::find(auth('user-api')->user()->id);
            $ads_minutes = Setting::first()->value('ad_time');
            $ads_points = Setting::first()->value('ad_point');
            $old_open = Carbon::parse($user->open_ad_time)->addMinutes($ads_minutes)->format('Y-m-d H:i:s');
            $next_open = Carbon::now()->format('Y-m-d H:i:s');


            if ($old_open <= $next_open) {
                return self::returnResponseDataApi(['status' => 1], 'تم فتح الاعلان البيني بنجاح');
            } else {
                return self::returnResponseDataApi(['status' => 0], 'تم فتح الاعلان البيني بالفعل');
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

    public function collectAdsWithPoints(): JsonResponse
    {
        try {
            $user = User::find(auth('user-api')->user()->id);
            $ads_minutes = Setting::first()->value('ad_time');
            $ads_points = Setting::first()->value('ad_point');
            $old_open = Carbon::parse($user->open_ad_time)->addMinutes($ads_minutes)->format('Y-m-d H:i:s');
            $next_open = Carbon::now()->format('Y-m-d H:i:s');

            // condition check and open ads
            if ($old_open <= $next_open) {
                $user->open_ad_time = Carbon::now()->format('Y-m-d H:i:s');
                $user->points += $ads_points;
                $user->save();
                return self::returnResponseDataApi(['status' => 1], 'تم تحصيل نقاط الاعلان البيني بنجاح');
            } else {
                return self::returnResponseDataApi(['status' => 0], 'تم تحصيل نقاط الاعلان البيني بالفعل');
            }
        } catch (Exception $e) {
            return self::returnResponseDataApi(null, $e->getMessage(), 500);
        }
    }

} // eldapour
###############|> Made By https://github.com/eldapour (eldapour) 🚀
