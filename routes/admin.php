<?php


use Illuminate\Support\Facades\{
    Route,
    Artisan,
};
use App\Http\Controllers\Admin\{
    AuthController,
    UserController,
    AdminController,
    CityController,
    InterestController,
    PackageController
};

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('admin.login');
    Route::POST('login', [AuthController::class, 'login'])->name('admin.login');
});

Route::get('/', function () {
    return redirect()->route('adminHome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:user'], function () {
    Route::get('/', function () {
        return view('admin/index');
    })->name('adminHome');

    #============================ Admin ====================================
    Route::get('admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/create', [AdminController::class, 'showCreate'])->name('admin.create');
    Route::post('admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::get('admin/{id}/edit', [AdminController::class, 'showEdit'])->name('admin.edit');
    Route::put('admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update');
    Route::get('admin/{id}/delete', [AdminController::class, 'delete'])->name('delete.admin');
    Route::get('my_profile', [AdminController::class, 'myProfile'])->name('myProfile');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

    #============================ users ====================================
    Route::get('userPerson', [UserController::class, 'indexPerson'])->name('userPerson.index');
    Route::get('userCompany', [UserController::class, 'indexCompany'])->name('userCompany.index');
    Route::POST('user/delete', [UserController::class, 'delete'])->name('user_delete');
    Route::POST('change-status-user', [UserController::class, 'changeStatusUser'])->name('changeStatusUser');

    #============================ Package =====================================
    Route::get('packages', [PackageController::class, 'index'])->name('package.index');
    Route::get('package/create', [PackageController::class, 'showCreate'])->name('package.create');
    Route::post('package/store', [PackageController::class, 'storePackage'])->name('package.store');
    Route::get('package/{id}/edit', [PackageController::class, 'showEditPage'])->name('package.edit');
    Route::put('package/update/{id}', [PackageController::class, 'updatePackage'])->name('package.update');
    Route::get('package/{id}/delete', [PackageController::class, 'deletePackage'])->name('package.delete');


    #============================ City =====================================
    Route::get('cities', [CityController::class, 'index'])->name('city.index');
    Route::get('city/create', [CityController::class, 'showCreate'])->name('city.create');
    Route::post('city/store', [CityController::class, 'storeCity'])->name('city.store');
    Route::get('city/{id}/edit', [CityController::class, 'showEditCity'])->name('city.edit');
    Route::put('city/update/{id}', [CityController::class, 'updateCity'])->name('city.update');
    Route::get('city/{id}/delete', [CityController::class, 'deleteCity'])->name('city.delete');


    #============================ Interest ==================================
    Route::get('interests', [InterestController::class, 'index'])->name('interest.index');
    Route::get('interest/create', [InterestController::class, 'showCreate'])->name('interest.create');
    Route::post('interest/store', [InterestController::class, 'storeInterest'])->name('interest.store');
    Route::get('interest/{id}/edit', [InterestController::class, 'showEditInterest'])->name('interest.edit');
    Route::put('interest/update/{id}', [InterestController::class, 'updateInterest'])->name('interest.update');
    Route::get('interest/{id}/delete', [InterestController::class, 'deleteInterest'])->name('interest.delete');

    #============================ Notification =====================================


});




#=======================================================================
#============================ ROOT =====================================
#=======================================================================
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('key:generate');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return response()->json(['status' => 'success', 'code' => 1000000000]);
});
