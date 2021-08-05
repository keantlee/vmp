<?php
use Illuminate\Support\Facades\Route;

// Route::resource('user-management', 'UserManagementController');

Route::prefix('/user')->group(function () {
    Route::resource('/index','UserManagementController');
    Route::get('/list_of_users', 'UserManagementController@show')->name('user.show');
});



