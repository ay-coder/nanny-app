<?php

Route::group([
    "namespace"  => "Requests",
], function () {
    /*
     * Admin Requests Controller
     */

    // Route for Ajax DataTable
    Route::get("requests/get", "AdminRequestsController@getTableData")->name("requests.get-list-data");

    Route::resource("requests", "AdminRequestsController");
});