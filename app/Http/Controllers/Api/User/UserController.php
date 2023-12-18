<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public UserRepositoryInterface $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {

        $this->userRepositoryInterface = $userRepositoryInterface;

    } // constructor

    public function getAllCities(): JsonResponse
    {
        return $this->userRepositoryInterface->getAllCities();
    } // getAllCities

    public function getAllAreas(): JsonResponse
    {
        return $this->userRepositoryInterface->getAllAreas();
    } // getAllAreas

    public function getAllSettings(): JsonResponse
    {
        return $this->userRepositoryInterface->getAllSettings();
    } // getAllSettings

    public function getAllNotification(): JsonResponse
    {
        return $this->userRepositoryInterface->getAllNotification();
    } // get All Notification

    public function deleteUser(): JsonResponse
    {
        return $this->userRepositoryInterface->deleteUser();
    } // Delete User

    public function createTripRate(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->createTripRate($request);
    } // create Trip Rate

    public function register(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->register($request);
    } // register

    public function login(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->login($request);
    } // login

    public function logout(): JsonResponse
    {
        return $this->userRepositoryInterface->logout();
    } // logout

    public function deleteAccount(): JsonResponse
    {
        return $this->userRepositoryInterface->deleteAccount();
    } // deleteAccount

    public function home()
    {
        return $this->userRepositoryInterface->userHome();
    }

    public function editProfile(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->editProfile($request);
    } // editProfile

    public function createTrip(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->createTrip($request);
    } // startTrip With Track

    public function cancelTrip(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->cancelTrip($request);
    } // cancelTrip

    public function createScheduleTrip(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->createScheduleTrip($request);
    } // createScheduleTrip

    public function userAllTrip(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->userAllTrip($request);
    } // userAllTrip

    public function favouriteLocations(): JsonResponse
    {
        return $this->userRepositoryInterface->favouriteLocations();
    } // favouriteLocations

    public function createFavouriteLocations(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->createFavouriteLocations($request);
    } //  createFavouriteLocations

    public function removeFavouriteLocations(Request $request): JsonResponse
    {
        return $this->userRepositoryInterface->removeFavouriteLocations($request);
    } //  removeFavouriteLocations
}
