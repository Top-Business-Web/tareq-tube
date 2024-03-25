<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {

        $this->userRepository = $userRepository;

    } // constructor

    public function loginWithGoogle(Request $request): JsonResponse
    {
        return $this->userRepository->loginWithGoogle($request);
    } // end loginWithGoogle

    public function logout(): JsonResponse
    {
        return $this->userRepository->logout();
    } // end logout

    public function deleteUser(): JsonResponse
    {
        return $this->userRepository->deleteAccount();
    } // end deleteUser 

}
