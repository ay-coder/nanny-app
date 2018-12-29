<?php

Route::group([
    "namespace"  => "General",
], function () {
    /*
     * Admin General Controller
     */

    // Route for Ajax DataTable
    Route::get("general/get", "AdminGeneralController@getTableData")->name("general.get-list-data");

    Route::resource("general", "AdminGeneralController");
});