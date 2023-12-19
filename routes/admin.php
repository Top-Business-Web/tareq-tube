<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin'],function (){
    Route::get('login', [AuthController::class,'index'])->name('admin.login');
    Route::POST('login', [AuthController::class,'login'])->name('admin.login');
});

Route::get('/', function () {
   return redirect()->route('adminHome');
});

Route::group(['prefix'=>'admin','middleware'=>'auth:user'],function (){
    Route::get('/', function () {
        return view('admin/index');
    })->name('adminHome');

    #============================ Admin ====================================
    Route::get('admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/create', [AdminController::class, 'showCreate'])->name('admin.create');
    Route::post('admin/store', [AdminController::class, 'storeAdmin'])->name('admin.store');
    Route::get('admin/{id}/edit', [AdminController::class, 'showEdit'])->name('admin.edit');
    Route::put('admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update');
    Route::get('admin/{id}/delete',[AdminController::class,'delete'])->name('delete.admin');
    Route::get('my_profile',[AdminController::class,'myProfile'])->name('myProfile');
    Route::get('logout', [AuthController::class,'logout'])->name('admin.logout');

    #============================ users ====================================
    Route::get('userPerson',[UserController::class,'indexPerson'])->name('userPerson.index');
    Route::get('userCompany',[UserController::class,'indexCompany'])->name('userCompany.index');
    Route::POST('user/delete',[UserController::class,'delete'])->name('user_delete');
    Route::POST('change-status-user',[UserController::class,'changeStatusUser'])->name('changeStatusUser');

    #============================ city =====================================



    #============================ Slider =====================================



    #============================ setting ==================================

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
    return response()->json(['status' => 'success','code' =>1000000000]);
});









