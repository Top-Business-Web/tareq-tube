<?php

namespace App\Repository\Api\User;

use App\Http\Resources\UserResource;
use App\Interfaces\Api\User\UserRepositoryInterface;
use App\Models\DeviceToken;
use App\Models\InviteToken;
use App\Models\OnBoarding;
use App\Models\Setting;
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

    } // end login with google

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

    public function onBoarding(): JsonResponse
    {
        $onBoarding = OnBoarding::get();
        return self::returnResponseDataApi($onBoarding, 'تم الحصول علي البيانات بنجاح');
    } // onboarding

}
