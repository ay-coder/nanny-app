<?php

Route::group([
    "namespace"  => "Payment",
], function () {
    /*
     * Admin Payment Controller
     */

    // Route for Ajax DataTable
    Route::get("payment/get", "AdminPaymentController@getTableData")->name("payment.get-list-data");

    Route::resource("payment", "AdminPaymentController");
});