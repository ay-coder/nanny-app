<?php

Route::group([
    "namespace"  => "Plans",
], function () {
    /*
     * Admin Plans Controller
     */

    // Route for Ajax DataTable
    Route::get("plans/get", "AdminPlansController@getTableData")->name("plans.get-list-data");

    Route::resource("plans", "AdminPlansController");
});