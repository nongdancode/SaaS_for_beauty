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


Auth::routes();

//Route::get('/home', function() {
//    return view('home');
//})->name('home')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




//api for booking
Route::group(['middleware' => ['cors','web']], function () {
    Route::any('/api/booking/list_services', 'Booking\AppointmentController@getReadyServices');
    Route::any('/api/booking/list_employee', 'Booking\AppointmentController@getAllFromEmployee');
    Route::post('/api/booking/confirm', 'Booking\AppointmentController@confirmBooking');
    Route::post('/api/booking/charge', 'Booking\AppointmentController@confirmCharge');


//calendar admin
    Route::any('/api/admin/staffs', 'System\ScheduleTaskController@getStafffForSchdedule');
    Route::any('/api/admin/staffs/{staffid}/tasks', 'System\ScheduleTaskController@getServicesOfStaffForScheduling');
    Route::any('/api/admin/staffs/{staffid}/schedules', 'System\ScheduleTaskController@getScheduleForStaff');
    Route::any('/api/admin/schedules/{staffid}/tasks', 'System\ScheduleTaskController@editSchedule');


    Route::any('/api/admin/marketing', 'System\MarketingController@flectCustomerForMarketing')  ;
    Route::post('/api/admin/sms_sending', 'System\MarketingController@sendSMSForMkt');
    Route::post('/api/admin/mms_sending', 'System\MarketingController@sendMMSForMkt');
    Route::any('/api/admin/payment-manager', 'System\PaymentController@getTransactionByVendor');


    Route::any('/api/admin/customer_report', 'System\ReportController@apiCustomerReportByPieChart');
    Route::any('/api/admin/payment_report', 'System\ReportController@apiPaymentReportByPieChart')  ;



    //employee

    Route::any('api/admin/user-listpayment', 'System\EmployeeManageController@showCommissionTypeOfStaff')  ;
    Route::any('api/admin/user-listcommission', 'System\EmployeeManageController@showPaymentTypeOfStaff')  ;
    Route::any('api/admin/employees', 'System\EmployeeManageController@getAllEmployeeFromVendor')  ;



    //services
    Route::any('api/admin/services', 'System\ServiceManageController@getAllServicesByVendor')  ;
    Route::any('api/admin/add-services', 'System\EmployeeManageController@addServices')  ;
    Route::any('api/admin/user', 'System\EmployeeManageController@getAllEmployeeFromVendor')  ;

    //checkin-waitlist
    Route::any('api/checkin/customer', 'Booking\CheckinController@CustomerChecking');
    Route::any('api/admin/waitlist', 'System\CustomerWaitlistController@getWaitlist');


//upload image
    Route::any('api/admin/upload-image', 'System\UploadController@updateImage');









    Route::any('tests3', 'System\UploadController@testS3');
    Route::any('testmms', 'System\MarketingController@sendMMSForMkt');












    Route::any('api/admin/dendivsfaker', 'System\EmployeeManageController@getEmployeeForFakerNHOLAPHAIDELETECAIDOQUYNAY');
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
