<?php

use Illuminate\Support\Facades\Route;
Route::prefix('/budget')->group(function () {
    Route::get('/fund-source-encoding', 'BudgetModuleController@fund_source_encoding_view')->name('fund_encoding');
    Route::get('/fund-source-encoding/{reg_code}', 'BudgetModuleController@get_province');
    Route::post('/fund-source-encoding/submit_form', 'BudgetModuleController@fund_encoding_ors')->name('submit_encoding_form');
    Route::get('/fund-monitoring-and-disbursement','BudgetModuleController@fund_monitoring_and_disbursement_view')->name('fund_moni_and_disb');
    Route::get('/fund-monitoring-and-disbursement/view-fund-source-breakdown/{fund_id}', 'BudgetModuleController@get_fund_source_breakdown')->name('fund_breakdown');    
});

