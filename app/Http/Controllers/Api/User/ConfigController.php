<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    protected UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepositoryInterface = $userRepositoryInterface;
    } // constructor
    public function getInterests(): JsonResponse
    {
        return $this->userRepositoryInterface->getInterests();
    } // getInterests

    public function getCities(): JsonResponse
    {
        return $this->userRepositoryInterface->getCities();
    } // getCities

    public function setting(): JsonResponse
    {
        return $this->userRepositoryInterface->setting();
    } // getCities

}
