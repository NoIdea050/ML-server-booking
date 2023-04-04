<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\SliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', function() {
    return redirect()->route('user.dashboard');
});

Route::group(['as'=>'user.','prefix'=>'user','middleware'=>['auth','user']], function (){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });
    Route::post('/booking','DashboardController@booking')->name('booking');
    Route::post('/booking/{id}','DashboardController@booking_destroy')->name('booking-destroy');

    Route::post('/booking-check','DashboardController@booking_check')->name('booking-check');

    Route::get('/booking-history','DashboardController@booking_history')->name('booking-history');

    Route::get('/BookingJson','DashboardController@bookingsJson')->name('BookingJson');

    Route::get('/profile','DashboardController@profile')->name('profile');
    Route::put('/profile', 'DashboardController@profile_update')->name(
        'profile-update'
    );
    Route::put('/profile/change-password', 'DashboardController@passupdate')->name('change-password');

    Route::post('/request-for-credit','DashboardController@request_for_credit')->name('request-for-credit');
    Route::get('/request-for-credit-delete/{id}','DashboardController@request_for_credit_delete')->name('request-for-credit-delete');

});

Route::get('/admin/login', [AdminAuthController::class, 'admin_login'])->name('admin-login');
Route::post('/admin-login-check', [AdminAuthController::class, 'admin_login_check'])->name('admin-login-check');
Route::get('/admin/password/reset', [AdminAuthController::class, 'admin_password_reset'])->name('admin-password-reset');
Route::post('/admin/password/forgot',[AdminAuthController::class,'sendResetLink'])->name('admin.forgot.password.link');
Route::get('/admin/password/reset/{token}',[AdminAuthController::class,'showResetForm'])->name('admin.reset.password.form');
Route::post('/admin/password/reset',[AdminAuthController::class,'resetPassword'])->name('admin.reset.password');

Route::group(['as'=>'admin.','prefix'=>'admin','middleware'=>['auth:admin']], function (){
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/', function() {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');


    //-----------------------------System Settings START----------------------------
    Route::get('settings/system-info','Admin\SettingController@setting')->name('system.settings');
    Route::post('settings/system-info-update','Admin\SettingController@system_update')->name('system.settings.store');
    //-----------------------------System Settings END-----------------------------

    //-----------------------------User MANAGEMENT START----------------------------
    Route::resource('user', 'Admin\UserController');
    Route::get('user/status-change/{id}','Admin\UserController@status_change')->name('user.status.change');
    //-----------------------------User MANAGEMENT END-----------------------------

    //-----------------------------CREDIT HISTORY MANAGEMENT START----------------------------
    Route::get('user/credit-history/{user_id}','Admin\CreditHistoryController@index')->name('user.credit-history');
    Route::get('user/credit-history/create/{user_id}','Admin\CreditHistoryController@create')->name('user.credit-history.create');
    Route::get('user/credit-history/reject/{id}','Admin\CreditHistoryController@reject')->name('user.credit-history.reject');
    Route::get('user/credit-history/accept/{id}','Admin\CreditHistoryController@accept')->name('user.credit-history.accept');
    Route::resource('credit-history', 'Admin\CreditHistoryController');
    //-----------------------------CREDIT HISTORY MANAGEMENT END-----------------------------

    //-----------------------------Booking MANAGEMENT START----------------------------
    Route::get('/booking','Admin\BookingController@index')->name('booking.index');
    Route::post('/booking/apporved/{id}','Admin\BookingController@booking_apporved')->name('booking-apporved');
    Route::get('booking/rejected/{id}','Admin\BookingController@booking_rejected' )->name('booking-rejected');
    //-----------------------------Booking MANAGEMENT END-----------------------------


    //-----------------------------STORAGE MANAGEMENT START----------------------------
    Route::resource('storage', 'Admin\StorageController');
    Route::get('storage/status-change/{id}','Admin\StorageController@status_change')->name('storage.status.change');
    //-----------------------------STORAGE MANAGEMENT END-----------------------------

    //--------------Admin profile start-----------------------
    Route::resource('/profile', 'Admin\ProfileController');
    Route::put('change-password/{id}', 'Admin\ProfileController@passupdate')->name('change.password');
    //--------------Admin profile end-----------

});