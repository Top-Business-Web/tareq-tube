<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class CheckPhoneController extends Controller{

    public function checkPhone(Request $request): JsonResponse
    {
        if ($request->phone == null){
            return self::returnResponseDataApi(null, 'يرجي ادخال رقم الهاتف', 422, 422);
        }
        $user = User::query()
            ->where('phone','=',$request->phone)
            ->first();

        if ($user){
             $data = ["status" => $user->status];
            if($user->status  == 1){
                ResetCodePassword::query()->where('phone', $request->phone)
                ->delete();

                ResetCodePassword::create(['phone' => $request->phone]);
                $data = ["status" => $user->status];
                return response()->json([
                    "status" => $user->status,
                    "message" => "الهاتف موجود من قبل",
                    "code" => 200,
                ],200);
            }else{
                return response()->json([
                    "status" => $user->status,
                    "message" => "الهاتف موجود من قبل ولكن الحساب غير مفعل",
                    "code" => 422,
                ],422);
            }

        }else {
            $user = User::query()
            ->where('phone','=',$request->phone)
            ->onlyTrashed()
            ->first();
            if($user){
                return self::returnResponseDataApi(null,"يوجد حساب محذوف بهذا الرقم يرجي التواصل مع الدعم",500,200);
            }else {
                return self::returnResponseDataApi(null,"الهاتف ليس موجود من قبل",406,200);

            }

        }

    }

}
