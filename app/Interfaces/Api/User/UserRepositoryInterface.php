<?php

namespace App\Interfaces\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loginWithGoogle(Request $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function deleteAccount(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getInterests(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getCities(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getHome(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function configCount(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTube(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addMessage(Request $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function setting(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function notification(): JsonResponse;
    public function mySubscribe(): JsonResponse;
    public function myViews(): JsonResponse;
    public function myProfile(): JsonResponse;
    public function addChannel(Request $request): JsonResponse;

}
//Made By https://github.com/eldapour (eldapour)
