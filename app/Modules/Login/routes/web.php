<?php
use Illuminate\Support\Facades\Route;

/**
 * Login
 */
Route::prefix('/login')->group(function () {
    Route::get('/', 'LoginController@index')->name('main.page');
    Route::post('/verify', 'LoginController@login_action')->name('user.login');
    Route::get('/otp_page_form', 'OTPController@otp_page')->name('otp_page');
    // check input otp is correct and not expired
    Route::post('/otp_page_form/otp_verify', 'OTPController@verify_OTP_form')->name('form.check_otp_verification');
    // reset otp
    Route::patch('/otp_page_form/reset_otp', 'OTPController@resend_otp')->name('reset_otp_link');
});


/**
 * Password
 */
Route::get('/form_reset_password_link', 'LoginController@show_link_request_form')->name('form.confirmation.reset.password');
Route::post('/form_reset_password_link/sending_request', 'LoginController@send_btn_link_req_form')->name('send.req.pwd.link');
Route::get('/create_new_password/{uuid}', 'LoginController@change_password_form')->name('user.change.password');
Route::patch('/create_new_password/{uuid}/update', 'LoginController@update_password')->name('update.password');
/**
 * Logout
 */
Route::get('/logout', 'LoginController@logout_action')->name('user.logout');
