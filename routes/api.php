<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ConfigController;
use App\Http\Controllers\Api\User\PaymentController;
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
Route::group(['prefix' => 'auth'], function () {
    Route::post('loginWithGoogle', [AuthController::class, 'loginWithGoogle']);
});
########################### END AUTH ROUTES ###################################


######################### START USER ROUTES ###################################
Route::group(['middleware' => 'jwt'], function () {

    Route::get('/getHome', [UserController::class, 'getHome']);
    Route::get('/configCount', [UserController::class, 'configCount']);

    //--------------------- User Actions -----------------------
    //= ROUTE POST DATA
    Route::post('/checkUser', [UserController::class, 'checkUser']);
    Route::post('/addTube', [UserController::class, 'addTube']);
    Route::post('/addMessage', [UserController::class, 'addMessage']);
    Route::post('/addChannel', [UserController::class, 'addChannel']);
    Route::post('/addPointSpin', [UserController::class, 'addPointSpin']);
    Route::post('/checkPointSpin', [UserController::class, 'checkPointSpin']);
    Route::post('/addPointCopun', [UserController::class, 'addPointCopun']);
    Route::post('/getTubeRandom', [UserController::class, 'getTubeRandom']);
    Route::post('/userViewTube', [UserController::class, 'userViewTube']);
    Route::post('/addLinkPoints', [UserController::class, 'addLinkPoints']);

    //= ROUTE GET DATA
    Route::get('/notification', [UserController::class, 'notification']);
    Route::get('/mySubscribe', [UserController::class, 'mySubscribe']);
    Route::get('/myViews', [UserController::class, 'myViews']);
    Route::get('/myProfile', [UserController::class, 'myProfile']);
    Route::get('/buyCoinsOrMsg', [UserController::class, 'getPageCoinsOrMsg']);
    Route::get('/getLinkInvite', [UserController::class, 'getLinkInvite']);
    Route::get('/getVipList', [UserController::class, 'getVipList']);
    Route::get('/myMessages', [UserController::class, 'myMessages']);
    Route::get('/getMessages', [UserController::class, 'getMessages']);


    //----------------------- Auth User ------------------------
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('deleteUser', [AuthController::class, 'deleteUser']);
});
########################### END USER ROUTES ###################################


######################### START GENERAL ROUTES ################################
Route::get('getInterests', [ConfigController::class, 'getInterests']);
Route::get('getCities', [ConfigController::class, 'getCities']);
Route::get('setting', [ConfigController::class, 'setting']);

########################### END GENERAL ROUTES ################################


######################### START PAYMENT ROUTES ################################
Route::group(['middleware' => 'jwt'], function () {
    Route::post('goPay', [PaymentController::class, 'goPay']);
    Route::post('checkout', [PaymentController::class, 'checkout']);
    Route::get('payment/callback', [PaymentController::class, 'callback']);
});
######################### END PAYMENT ROUTES ################################

