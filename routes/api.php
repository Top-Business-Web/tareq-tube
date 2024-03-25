<?php

use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\ConfigController;
use App\Http\Controllers\Api\User\PaymentController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| |> API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

############|> START AUTH ROUTES
Route::group(['prefix' => 'auth'], function () {
    Route::post('loginWithGoogle', [AuthController::class, 'loginWithGoogle']);
    Route::post('/checkUser', [UserController::class, 'checkUser']);
    Route::post('/checkDevice', [UserController::class, 'checkDevice']);
});
############|> END AUTH ROUTES

############|> START USER ROUTES

Route::group(['middleware' => 'jwt'], function () {

    #|> Route HOME & CONFIGURATION
    Route::get('/getHome', [UserController::class, 'getHome']);
    Route::get('/configCount', [UserController::class, 'configCount']);

    #|> ROUTE POST DATA
    Route::post('/addTube', [UserController::class, 'addTube']);
    Route::post('/addMessage', [UserController::class, 'addMessage']);
    Route::post('/addChannel', [UserController::class, 'addChannel']);
    Route::post('/addPointSpin', [UserController::class, 'addPointSpin']);
    Route::post('/checkPointSpin', [UserController::class, 'checkPointSpin']);
    Route::post('/addPointCopun', [UserController::class, 'addPointCopun']);
    Route::post('/getTubeRandom', [UserController::class, 'getTubeRandom']);
    Route::post('/userViewTube', [UserController::class, 'userViewTube']);
    Route::post('/addLinkPoints', [UserController::class, 'addLinkPoints']);
    Route::post('/withdraw', [UserController::class, 'withdraw']);

    #|> ROUTE GET DATA
    Route::get('/notification', [UserController::class, 'notification']);
    Route::get('/mySubscribe', [UserController::class, 'mySubscribe']);
    Route::get('/myViews', [UserController::class, 'myViews']);
    Route::get('/myProfile', [UserController::class, 'myProfile']);
    Route::get('/buyCoinsOrMsg', [UserController::class, 'getPageCoinsOrMsg']);
    Route::get('/getLinkInvite', [UserController::class, 'getLinkInvite']);
    Route::get('/getVipList', [UserController::class, 'getVipList']);
    Route::get('/myMessages', [UserController::class, 'myMessages']);
    Route::get('/getMessages', [UserController::class, 'getMessages']);

    #|> Auth User
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('deleteUser', [AuthController::class, 'deleteUser']);
});

############|> END USER ROUTES

############|> START GENERAL ROUTES0

Route::get('getInterests', [ConfigController::class, 'getInterests']);
Route::get('getCities', [ConfigController::class, 'getCities']);
Route::get('setting', [ConfigController::class, 'setting']);

############|> END GENERAL ROUTES

/*
 ? |> START PAYMENT ROUTES
 ? |> ROUTE GO PAY TO CREATE PAYMENT BY PAYMOB
 ! |> ROUTE PAYMENT/CALLBACK TO GET RESPONSE FROM PAYMOB =>> TURE OR FALSE
 ? |> ROUTE CHECKOUT TO FINISH PAYMENT BY PAYMOB
 */
############|> START PAYMENT ROUTES

#|> create new payment & order
Route::post('goPay', [PaymentController::class, 'goPay'])->middleware('jwt');
#|> callback payment true or false
Route::get('payment/callback', [PaymentController::class, 'callback']);
#|> check out & finish payment
Route::post('checkout', [PaymentController::class, 'checkout']);

############|> END PAYMENT ROUTES


############|> START FCM TEST ROUTES
Route::post('testFcm',[ConfigController::class,'testFcm']);
############|> END FCM TEST ROUTES

############|> START get Active Key ROUTES
Route::get('getActiveKey',[ConfigController::class,'getActiveKey']);
############|> END get Active Key ROUTES
