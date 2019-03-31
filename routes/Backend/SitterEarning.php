<?php

Route::group([
    "namespace"  => "SitterEarning",
], function () {
    /*
     * Admin SitterEarning Controller
     */

    Route::get("sitterearning/filter", "AdminSitterEarningController@filter")->name("sitterearning.filter");
    
    // Route for Ajax DataTable
    Route::get("sitterearning/get", "AdminSitterEarningController@getTableData")->name("sitterearning.get-list-data");

    Route::resource("sitterearning", "AdminSitterEarningController");
});