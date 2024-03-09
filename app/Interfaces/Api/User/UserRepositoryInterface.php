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
     * addMessage function
     *
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

    /**
     * @return JsonResponse
     */
    public function mySubscribe(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function myViews(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function myMessages(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getMessages(): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function myProfile(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addChannel(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPageCoinsOrMsg(Request $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getLinkInvite(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function AddLinkPoints(Request $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function getVipList(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPointSpin(Request $request): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function checkPointSpin(): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addPointCopun(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getTubeRandom(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userViewTube(Request $request):  JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUser(Request $request):  JsonResponse;


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkDevice(Request $request):  JsonResponse;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function withdraw(Request $request): JsonResponse;
}
###############|> Made By https://github.com/eldapour (eldapour) 🚀
