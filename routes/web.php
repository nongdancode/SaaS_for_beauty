<?php

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
    return view('welcome');
});

Route::get('/booking', function () {
    return view('booking_template/booking');
});

Route::get('/admin', function () {
    return view('admin/admin');
});

Route::get('/admin/sms', function () {
    return view('admin/sms_sending');
});
Route::get('/terms', function () {
    return view('booking_template/term');
});

Route::any('/admin/login', function () {
    return view('admin/login');
});
Route::any('/admin/admin_register_user', function () {
    return view('admin/register_admin');
});
Route::any('/admin/sms', 'System\SmsController@showSupplyCustomerPhone');
Route::any('/admin/admin_register_confirm', 'Auth\RegisterController@createUserAdminRole');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
