<?php

use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\Driver\TripController as DriverTripController;
use App\Http\Controllers\Api\User\CheckPhoneController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

######################### START AUTH ROUTES ###################################
Route::post('checkPhone', [CheckPhoneController::class, 'checkPhone']);
Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/login', [UserController::class, 'login']);
########################### END AUTH ROUTES ###################################




######################### START USER ROUTES ###################################
Route::group(['middleware' => 'jwt'],function (){

    Route::get('userHome',[UserController::class,'home']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('editProfile', [UserController::class, 'editProfile']);
    Route::post('deleteAccount', [UserController::class, 'deleteAccount']);
    Route::get('favouriteLocations', [UserController::class, 'favouriteLocations']);
    Route::post('createFavouriteLocations', [UserController::class, 'createFavouriteLocations']);
    Route::post('removeFavouriteLocations', [UserController::class, 'removeFavouriteLocations']);
    Route::get('setting', [UserController::class, 'setting']);
    Route::get('notifications', [UserController::class, 'getAllNotification']);
    Route::post('deleteUser', [UserController::class, 'deleteUser']);
    Route::post('logout', [UserController::class, 'logout']);

    #### TRIP ROUTES #####
    Route::post('createTrip', [UserController::class, 'createTrip']);
    Route::post('cancelUserTrip', [UserController::class, 'cancelTrip']);
    Route::post('createScheduleTrip', [UserController::class, 'createScheduleTrip']);
    Route::get('userAllTrip', [UserController::class, 'userAllTrip']);
    Route::post('createTripRate', [UserController::class, 'createTripRate']);

});
########################### END USER ROUTES ###################################




######################### START DRIVER ROUTES #################################
Route::group(['middleware' => 'jwt'],function (){

    Route::post('storeDriverDetails', [DriverController::class, 'registerDriver']);
    Route::post('updateDriverDetails', [DriverController::class, 'updateDriverDetails']);
    Route::post('storeDriverDocument', [DriverController::class, 'registerDriverDoc']);
    Route::post('updateDriverDocument', [DriverController::class, 'updateDriverDocument']);
    Route::post('checkDocument', [DriverController::class, 'checkDocument']);
    Route::post('changeStatus', [DriverController::class, 'changeStatus']);
    Route::get('driverWallet', [DriverController::class, 'driverWallet']);
    Route::get('driverProfit', [DriverController::class, 'driverProfit']);
    #### TRIPS ROUTES ####
    Route::post('startQuickTrip', [DriverTripController::class, 'startQuickTrip']);
    Route::post('endQuickTrip', [DriverTripController::class, 'endQuickTrip']);
    Route::post('acceptTrip', [DriverTripController::class, 'acceptTrip']);
    Route::post('cancelTrip', [DriverTripController::class, 'cancelTrip']);
    Route::post('startTrip', [DriverTripController::class, 'startTrip']);
    Route::post('endTrip', [DriverTripController::class, 'endTrip']);
    Route::get('driverAllTrip',[DriverTripController::class,'driverAllTrip']);
});
######################### END DRIVER ROUTES ###################################




######################### START GENERAL ROUTES ################################
Route::get('cities', [UserController::class, 'getAllCities']);
Route::get('areas', [UserController::class, 'getAllAreas']);
Route::get('settings', [UserController::class, 'getAllSettings']);
########################### END GENERAL ROUTES ################################
