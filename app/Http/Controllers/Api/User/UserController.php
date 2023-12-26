<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    } // constructor

    public function getHome(): JsonResponse
    {
        return $this->userRepositoryInterface->getHome();
    } // getHome

    public function configCount(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->configCount($request);
    } // config count actions

    public function addTube(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addTube($request);
    } // add tubes

    public function addMessage(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addMessage($request);
    } // add message

    public function notification(): JsonResponse
    {
        return $this->userRepositoryInterface->notification();
    } // notification

    public function mySubscribe(): JsonResponse
    {
        return $this->userRepositoryInterface->mySubscribe();
    } // my subscribe

    public function myViews(): JsonResponse
    {
        return $this->userRepositoryInterface->myViews();
    } // my views

    public function myProfile(): JsonResponse
    {
        return $this->userRepositoryInterface->myProfile();
    } // my views

    public function addChannel(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addChannel($request);
    } // my views
}
