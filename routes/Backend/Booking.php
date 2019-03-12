<?php

Route::group([
    "namespace"  => "Booking",
], function () {
    /*
     * Admin Booking Controller
     */

    // Route for Ajax DataTable
    Route::get("booking/get", "AdminBookingController@getTableData")->name("booking.get-list-data");

     // Route for Ajax DataTable
    Route::get("booking/cancel", "AdminBookingController@cancel")->name("booking.cancel");

    Route::get("booking/get-babies", "AdminBookingController@getBabies")->name("booking.get-babies");

    Route::resource("booking", "AdminBookingController");
});