<?php

Route::group([
    "namespace"  => "SitterEarning",
], function () {
    /*
     * Admin SitterEarning Controller
     */

    // Route for Ajax DataTable
    Route::get("sitterearning/get", "AdminSitterEarningController@getTableData")->name("sitterearning.get-list-data");

    Route::resource("sitterearning", "AdminSitterEarningController");
});