<?php

Route::group([
    "namespace"  => "Activation",
], function () {
    /*
     * Admin Activation Controller
     */

    // Route for Ajax DataTable
    Route::get("activation/get", "AdminActivationController@getTableData")->name("activation.get-list-data");

    Route::resource("activation", "AdminActivationController");
});