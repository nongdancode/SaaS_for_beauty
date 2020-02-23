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
    return view('booking_template/booking2');
});
Route::get('/booking3', function () {
    return view('booking_template/booking3');
});
Route::get('/checkin', function () {
    return view('booking_template/checkin');
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



Route::any('/admin/sms2', 'System\SmsController@showSupplyCustomerPhone');
Route::any('/admin/smsapi', 'System\SmsController@getCustomerByvendor');
Route::any('/admin/sms', function () {
    return view('admin/sms_sending2');
});

Route::get('/admin2', function () {
    return view('admin2/index');
});






Route::get('/terms', function () {
    return view('booking_template/sms_sending');
});

Route::get('/admin', function () {
    return view('admin/admin');
});

Route::any('/admin/admin_register_confirm', 'Auth\RegisterController@createUserAdminRole');
Route::any('/test', 'System\SMSController@showSupplyCustomerPhone');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

//Route::get('/home', function() {
//    return view('home');
//})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::any('/usersxx', 'System\SmsController@test');


//api for booking
Route::group(['middleware' => ['cors','web']], function () {
    Route::any('/api/booking/list_services', 'Booking\AppointmentController@getReadyServices');
    Route::any('/api/booking/list_employee', 'Booking\AppointmentController@getAllFromEmployee');
    Route::any('/api/booking/confirm', 'Booking\AppointmentController@confirmBooking');
    Route::any('/api/booking/charge', 'Booking\AppointmentController@confirmCharge');


//calendar admin
    Route::any('/api/admin/staffs', 'System\ScheduleTaskController@getStafffForSchdedule');
    Route::any('/api/admin/staffs/{staffid}/tasks', 'System\ScheduleTaskController@getServicesOfStaffForScheduling');
    Route::any('/api/admin/staffs/{staffid}/schedules', 'System\ScheduleTaskController@getScheduleForStaff');


    Route::any('/api/admin/marketing', 'System\MarketingController@flectCustomerForMarketing')  ;
    Route::any('/api/admin/sms_sending', 'System\MarketingController@sendSMSForMkt');
    Route::any('/api/admin/payment-manager', 'System\PaymentController@getTransactionByVendor');


    Route::any('/api/admin/customer_report', 'System\ReportController@apiCustomerReportByPieChart');
    Route::any('/api/admin/payment_report', 'System\ReportController@apiPaymentReportByPieChart')  ;




});
//Route::any('/api/booking/list_services', 'Booking\AppointmentController@getReadyServices');
//Route::any('/api/booking/list_employee', 'Booking\AppointmentController@getAllFromEmployee');
//Route::get('/api/booking/confirm', 'Booking\AppointmentController@confirmBooking');
//
//
//
//Route::any('/api/admin/mkt_customer', 'System\MarketingController@flectCustomerForMarketing')  ;
//Route::any('/api/admin/sms_sending', 'System\MarketingController@sendSMSForMkt');
//Route::any('/api/admin/payment', 'System\PaymentController@getTransactionByVendor');
//
//
//Route::any('api/admin/customer_report', 'System\ReportController@apiCustomerReportByPieChart');
//Route::any('api/admin/payment_report', 'System\ReportController@apiPaymentReportByPieChart')  ;

//api for admin



Route::any('/test', 'Booking\AppointmentController@confirmBooking');
