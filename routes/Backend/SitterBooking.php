<?php

Route::group([
    "namespace"  => "SitterBooking",
], function () {
    /*
     * Admin SitterBooking Controller
     */

    // Route for Ajax DataTable
    Route::get("sitterbooking/filter", "AdminSitterBookingController@filter")->name("sitterbooking.filter");
    // Route for Ajax DataTable
    Route::get("sitterbooking/get", "AdminSitterBookingController@getTableData")->name("sitterbooking.get-list-data");

    Route::resource("sitterbooking", "AdminSitterBookingController");
});