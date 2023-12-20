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
    }

    public function configCount(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->configCount($request);
    }

    public function addTube(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addTube($request);
    }

    public function addMessage(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->addMessage($request);
    }

}
