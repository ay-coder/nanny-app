<?php

Route::group([
    "namespace"  => "Babies",
], function () {
    /*
     * Admin Babies Controller
     */

    // Route for Ajax DataTable
    Route::get("babies/get", "AdminBabiesController@getTableData")->name("babies.get-list-data");

    Route::resource("babies", "AdminBabiesController");
});