<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\DriverDocumentController;
use App\Http\Controllers\Admin\InvoiceSettingController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarehouseController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin'],function (){
    Route::get('login', [AuthController::class,'index'])->name('admin.login');
    Route::POST('login', [AuthController::class,'login'])->name('admin.login');
});

Route::get('/', function () {
   return redirect()->route('adminHome');
});

Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function (){
    Route::get('/', function () {
        return view('admin/index');
    })->name('adminHome');

    #============================ Admin ====================================
    Route::resource('admins', AdminController::class);
    Route::POST('delete_admin',[AdminController::class,'delete'])->name('delete_admin');
    Route::get('my_profile',[AdminController::class,'myProfile'])->name('myProfile');
    Route::get('logout', [AuthController::class,'logout'])->name('admin.logout');

    #============================ users ====================================
    Route::get('userPerson',[UserController::class,'indexPerson'])->name('userPerson.index');
    Route::get('userCompany',[UserController::class,'indexCompany'])->name('userCompany.index');
    Route::POST('user/delete',[UserController::class,'delete'])->name('user_delete');
    Route::POST('change-status-user',[UserController::class,'changeStatusUser'])->name('changeStatusUser');

    #============================ driver ===================================
    Route::resource('driver',DriverController::class);
    Route::POST('driver/delete',[UserController::class,'delete'])->name('driver_delete');

    #============================ city =====================================
    Route::resource('city',CityController::class);
    Route::POST('city/delete',[CityController::class,'delete'])->name('city_delete');

    #============================ Area =====================================
    Route::resource('area',AreaController::class);
    Route::POST('area/delete',[AreaController::class,'delete'])->name('area_delete');

    #============================ Slider =====================================
    Route::resource('slider',SliderController::class);
    Route::POST('slider/delete',[SliderController::class,'delete'])->name('slider_delete');
    Route::POST('change-status-slider',[SliderController::class,'changeStatusSlider'])->name('changeStatusSlider');

    #============================ Driver Document =====================================
    Route::resource('driver_document',DriverDocumentController::class);
    Route::POST('driver/delete',[DriverDocumentController::class,'delete'])->name('driver_delete');
    Route::POST('change-status-document',[DriverDocumentController::class,'changeStatusDocument'])->name('changeStatusDocument');

    #============================ Trip =====================================
    Route::get('trips/completed', [TripController::class, 'complete'])->name('trip.complete');
    Route::get('trips/completed/{trip}', [TripController::class, 'showCompleteTrip'])->name('show.complete');
    Route::get('trips/new', [TripController::class, 'new'])->name('trip.new');
    Route::get('trips/new/{trip}', [TripController::class, 'showNewTrip'])->name('show.new');
    Route::get('trips/reject', [TripController::class, 'reject'])->name('trip.reject');
    Route::get('trips/reject/{trip}', [TripController::class, 'showRejectTrip'])->name('show.reject');
    Route::POST('trip/delete',[TripController::class,'delete'])->name('trip_delete');

    #============================ setting ==================================
    Route::get('setting',[SettingController::class,'index'])->name('settingIndex');
    Route::POST('setting/update/{id}',[SettingController::class,'update'])->name('settingUpdate');

    #============================ Notification =====================================
    Route::resource('notifications',NotificationController::class);
    Route::POST('notifications/delete',[NotificationController::class,'delete'])->name('notification_delete');


});




#=======================================================================
#============================ ROOT =====================================
#=======================================================================
Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('key:generate');
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    return response()->json(['status' => 'success','code' =>1000000000]);
});









