<?php

Route::group([
    "namespace"  => "Booking",
], function () {
    /*
     * Admin Booking Controller
     */

    // Route for Ajax DataTable
    Route::get("booking/get", "AdminBookingController@getTableData")->name("booking.get-list-data");

    Route::resource("booking", "AdminBookingController");
});