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
    ConfigCountController,
    CouponController,
    InterestController,
    MsgController,
    NotificationController,
    PackageController,
    PackageUserController,
    SliderController,
    UserActionController,
    TubeController,
    ModelPriceController,
    SettingController,
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

    #============================ Packages Users =====================================
    Route::get('packages_users', [PackageUserController::class, 'index'])->name('package_user.index');
    Route::get('package_user/{id}/delete', [PackageUserController::class, 'deletePackageUser'])->name('package_user.delete');


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

    #============================ Config Count =====================================
    Route::get('config_count', [ConfigCountController::class, 'index'])->name('config_count.index');
    Route::get('config_count/create', [ConfigCountController::class, 'showCreate'])->name('config_count.create');
    Route::post('config_count/store', [ConfigCountController::class, 'storeConfigCount'])->name('config_count.store');
    Route::get('config_count/{id}/edit', [ConfigCountController::class, 'showEditConfigCount'])->name('config_count.edit');
    Route::put('config_count/update/{id}', [ConfigCountController::class, 'updateConfigCount'])->name('config_count.update');
    Route::get('config_count/{id}/delete', [ConfigCountController::class, 'deleteConfigCount'])->name('config_count.delete');

    #============================ Slider =====================================
    Route::get('sliders', [SliderController::class, 'index'])->name('slider.index');
    Route::get('slider/create', [SliderController::class, 'showCreate'])->name('slider.create');
    Route::post('slider/store', [SliderController::class, 'storeSlider'])->name('slider.store');
    Route::get('slider/{id}/edit', [SliderController::class, 'showEditSlider'])->name('slider.edit');
    Route::put('slider/update/{id}', [SliderController::class, 'updateSlider'])->name('slider.update');
    Route::get('slider/{id}/delete', [SliderController::class, 'deleteSlider'])->name('slider.delete');

    #============================ Message =====================================
    Route::get('messages', [MsgController::class, 'index'])->name('message.index');
    Route::get('messages/{id}/delete', [MsgController::class, 'deleteMessage'])->name('message.delete');

    #============================ Notification =====================================
    Route::get('notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('notification/create', [NotificationController::class, 'showCreate'])->name('notification.create');
    Route::post('notification/store', [NotificationController::class, 'storeNotification'])->name('notification.store');
    Route::get('notification/{id}/edit', [NotificationController::class, 'showEditNotification'])->name('notification.edit');
    Route::put('notification/update/{id}', [NotificationController::class, 'updateNotification'])->name('notification.update');
    Route::get('notification/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notification.delete');

    #============================ Coupon =====================================
    Route::get('coupons', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('coupon/create', [CouponController::class, 'showCreate'])->name('coupon.create');
    Route::post('coupon/store', [CouponController::class, 'storeCoupon'])->name('coupon.store');
    Route::get('coupon/{id}/edit', [CouponController::class, 'showEditCoupon'])->name('coupon.edit');
    Route::put('coupon/update/{id}', [CouponController::class, 'updateCoupon'])->name('coupon.update');
    Route::get('coupon/{id}/delete', [CouponController::class, 'deleteCoupon'])->name('coupon.delete');

    #============================ User Action =====================================
    Route::get('user_actions', [UserActionController::class, 'index'])->name('userAction.index');
    Route::get('user_actions/{id}/delete', [UserActionController::class, 'deleteUserAction'])->name('userAction.delete');

    #============================ Tube =====================================
    Route::get('tubes', [TubeController::class, 'index'])->name('tube.index');
    Route::get('tube/{id}/delete', [TubeController::class, 'deleteTube'])->name('tube.delete');

    #============================ Model Price =====================================
    Route::get('model_prices', [ModelPriceController::class, 'index'])->name('modelPrice.index');
    Route::get('model_price/create', [ModelPriceController::class, 'showCreate'])->name('modelPrice.create');
    Route::post('model_price/store', [ModelPriceController::class, 'storeModelPrice'])->name('modelPrice.store');
    Route::get('model_price/{id}/edit', [ModelPriceController::class, 'showEditModelPrice'])->name('modelPrice.edit');
    Route::put('model_price/update/{id}', [ModelPriceController::class, 'updateModelPrice'])->name('modelPrice.update');
    Route::get('model_price/{id}/delete', [ModelPriceController::class, 'deleteModelPrice'])->name('modelPrice.delete');

    #============================ Setting =====================================
    Route::get('setting/edit', [SettingController::class, 'showEditSetting'])->name('setting.edit');
    Route::put('setting/update/{id}', [SettingController::class, 'updateSetting'])->name('setting.update');

});




#=======================================================================
#============================ ROOT =====================================
#=======================================================================
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('key:generate');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    return response()->json(['status' => 'success', 'code' => 1000000000]);
});
