<?php

Route::group([
    "namespace"  => "Sample",
], function () {
    /*
     * Admin Sample Controller
     */

    // Route for Ajax DataTable
    Route::get("sample/get", "AdminSampleController@getTableData")->name("sample.get-list-data");

    Route::resource("sample", "AdminSampleController");
});