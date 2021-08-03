<?php
use Illuminate\Support\Facades\Route;

Route::prefix('/farmer')->group(function () {
    Route::get('/index', 'FarmerModuleController@list_of_farmers_info_view')->name("farmer.main");
    // Route::get('/view-details/{id}', 'FarmerModuleController@farmer_details_modal')->name("farmer.details");

    // This route is for viewing the farmer details for the new page. 
    Route::get('/view-details/{id}','FarmerModuleController@view_farmer_details_page')->name("farmer.view.details.page");
});
