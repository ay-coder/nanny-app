<?php

Route::group([
    "namespace"  => "Subscription",
], function () {
    /*
     * Admin Subscription Controller
     */

    Route::get("subscription/filter", "AdminSubscriptionController@filter")->name("subscription.filter");
    
    // Route for Ajax DataTable
    Route::get("subscription/get", "AdminSubscriptionController@getTableData")->name("subscription.get-list-data");

    Route::resource("subscription", "AdminSubscriptionController");
});