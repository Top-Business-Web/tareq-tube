<?php

use App\Http\Controllers\Api\User\AuthController;
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
Route::group(['prefix' => 'auth'],function (){
    Route::post('loginWithGoogle',[AuthController::class,'loginWithGoogle']);
});
########################### END AUTH ROUTES ###################################




######################### START USER ROUTES ###################################
Route::group(['middleware' => 'jwt'],function (){
    Route::get('onBoarding',[UserController::class,'onBoarding']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('deleteUser',[AuthController::class,'deleteUser']);
});
########################### END USER ROUTES ###################################



######################### START GENERAL ROUTES ################################

########################### END GENERAL ROUTES ################################
