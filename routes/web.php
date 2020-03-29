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
    Route::get('/api/booking/list_services', 'Booking\AppointmentController@getReadyServices');

    Route::get('/api/booking/list_employee', 'Booking\AppointmentController@getAllFromEmployee');
    Route::post('/api/booking/confirm', 'Booking\AppointmentController@confirmBooking');
    Route::post('/api/booking/charge', 'Booking\AppointmentController@confirmCharge');

    Route::get('/api/booking/list_groups', 'Booking\AppointmentController@listGroupService');


//calendar admin
    Route::any('/api/admin/staffs', 'System\ScheduleTaskController@getStafffForSchdedule');
    Route::any('/api/admin/staffs/{staffid}/tasks', 'System\ScheduleTaskController@getServicesOfStaffForScheduling');
    Route::any('/api/admin/staffs/{staffid}/schedules', 'System\ScheduleTaskController@getScheduleForStaff');
    Route::post('/api/admin/schedules/{staffid}/tasks', 'System\ScheduleTaskController@editSchedule');


    //calendar ver2
    Route::post('/api/admin/shifts', 'System\ShiftController@addShiftForEmployee');
    Route::get(' /api/admin/schedules/{employeeId}/shifts', 'System\ShiftController@listShiftForEmployee');
    Route::get(' /api/admin/shifts/{id}/tasks', 'System\ShiftController@listShiftDetail');
    Route::get(' /api/admin/shifts', 'System\ShiftController@showFullCalendar');
    Route::delete(' /api/admin/shifts/{shiftid}', 'System\ShiftController@deleteShift');





    Route::get('/api/admin/marketing', 'System\MarketingController@flectCustomerForMarketing')  ;
    Route::post('/api/admin/sms_sending', 'System\MarketingController@sendSMSForMkt');
    Route::post('/api/admin/mms_sending', 'System\MarketingController@sendMMSForMkt');
    Route::get('/api/admin/payment-manager', 'System\PaymentController@getTransactionByVendor');
    Route::put('/api/admin/marketing', 'System\MarketingController@editCustomer');
    Route::get('/api/admin/history-customer/{id}', 'System\CustomerManagementController@showCustomerHistory');





    Route::any('/api/admin/customer_report', 'System\ReportController@apiCustomerReportByPieChart');
    Route::any('/api/admin/payment_report', 'System\ReportController@apiPaymentReportByPieChart')  ;



    //employee

    Route::get('api/admin/user-listpayment', 'System\EmployeeManageController@showCommissionTypeOfStaff')  ;

    Route::get('api/admin/employees', 'System\EmployeeManageController@getAllEmployeeFromVendor')  ;
    Route::post('api/admin/employees', 'System\EmployeeManageController@addEmployee')  ;
    Route::put('api/admin/employees', 'System\EmployeeManageController@editEmployee')  ;
    Route::delete('api/admin/employees/{id}', 'System\EmployeeManageController@deleteEmployee')  ;



    //services
    Route::get('api/admin/services', 'System\ServiceManageController@getAllServicesByVendorForCrud')  ;
    Route::post('api/admin/services', 'System\ServiceManageController@addServiceForCrud')  ;
    Route::put('api/admin/services', 'System\ServiceManageController@updateServiceForCrud')  ;
    Route::delete('api/admin/services/{id}', 'System\ServiceManageController@deleteServiceForCrud')  ;

    //group servive
    Route::get('api/admin/groups', 'System\GroupServiceController@listGroupService')  ;
    Route::post('api/admin/groups', 'System\GroupServiceController@addGroupService')  ;
    Route::put('api/admin/groups', 'System\GroupServiceController@editGroupService')  ;
    Route::delete('api/admin/groups/{id}', 'System\GroupServiceController@deleteGroupService')  ;

    //employee

    Route::post('api/admin/add-services', 'System\EmployeeManageController@addServices')  ;
    Route::get('api/admin/user', 'System\EmployeeManageController@getAllEmployeeFromVendor')  ;

    //checkin-waitlist
    Route::post('api/checkin/customer', 'Booking\CheckinController@CustomerChecking');
    Route::get('api/admin/waitlist', 'System\CustomerWaitlistController@getWaitlist');
    Route::post('api/admin/checkout/confirm', 'System\CustomerWaitlistController@confirmCheckoutWaitlist');
    Route::post('api/admin/checkin/confirm', 'System\CustomerWaitlistController@CheckinToCheckoutWaitlist');

    //transaction
    Route::get('/api/admin/transaction', 'System\PaymentController@getBillTransactionByVendor');




//upload image
    Route::any('api/admin/upload-image', 'System\UploadController@updateImage');




//shift api
    Route::post('api/admin/shifts', 'System\ShiftController@addShiftForEmployee');




    Route::any('tests3', 'System\UploadController@testS3');
    Route::any('testmms', 'System\MarketingController@sendMMSForMkt');


    //login jwt

    Route::get('system/login', 'System\LoginController@login');



   //Salary

    Route::get('api/admin/income', 'System\SalaryController@calculateSalary');







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
