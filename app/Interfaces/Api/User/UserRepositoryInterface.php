<?php

namespace App\Interfaces\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserRepositoryInterface{
    public function loginWithGoogle(Request $request);
    public function logout(): JsonResponse;
    public function deleteAccount(): JsonResponse;
    public function onBoarding(): JsonResponse;
    //Made By https://github.com/eldapour (eldapour)
}
