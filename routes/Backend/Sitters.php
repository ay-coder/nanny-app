<?php

Route::group([
    "namespace"  => "Sitters",
], function () {
    /*
     * Admin Sitters Controller
     */

    // Route for Ajax DataTable
    Route::get("sitters/get", "AdminSittersController@getTableData")->name("sitters.get-list-data");

    Route::resource("sitters", "AdminSittersController");
});