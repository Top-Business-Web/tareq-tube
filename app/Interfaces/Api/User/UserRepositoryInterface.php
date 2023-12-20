<?php

namespace App\Interfaces\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function loginWithGoogle(Request $request);

    public function logout(): JsonResponse;

    public function deleteAccount(): JsonResponse;

    public function getInterests(): JsonResponse;

    public function getCities(): JsonResponse;

    public function getHome(): JsonResponse;

    public function configCount(Request $request): JsonResponse;

    public function addTube(Request $request): JsonResponse;
    public function addMessage(Request $request): JsonResponse;

}
//Made By https://github.com/eldapour (eldapour)
