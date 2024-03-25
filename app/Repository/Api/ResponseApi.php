<?php

namespace App\Repository\Api;

use App\Traits\FirebaseNotification;
use Illuminate\Http\JsonResponse;

class ResponseApi
{
    use FirebaseNotification;

    // return response Data Api
    public static function returnResponseDataApi($data = null, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $code,

        ], $code);
    }

    // get random token by length string
    public static function randomToken($length_of_string): string
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%&';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public function sendFcm($title, $body, $user_id = null, $created = false, $interest_id = null)
    {
        $data = array('title' => $title, 'body' => $body);
        return $this->sendFirebaseNotification($data, $user_id, $created, $interest_id);
    }
}
