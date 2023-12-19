<?php

namespace App\Repository\Api;

use Illuminate\Http\JsonResponse;

class ResponseApi
{
    public static function returnResponseDataApi($data = null, string $message, int $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'code' => $code,

        ], $code);
    }

    public static function randomToken($length_of_string): string
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%&';
        return substr(str_shuffle($str_result),0, $length_of_string);
    }
}
