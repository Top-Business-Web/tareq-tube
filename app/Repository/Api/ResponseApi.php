<?php

namespace App\Repository\Api;

use Illuminate\Http\JsonResponse;

class ResponseApi
{
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
        return substr(str_shuffle($str_result),0, $length_of_string);
    }
}
