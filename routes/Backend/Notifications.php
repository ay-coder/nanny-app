<?php

Route::group([
    "namespace"  => "Notifications",
], function () {
    /*
     * Admin Notifications Controller
     */

    // Route for Ajax DataTable
    Route::get("notifications/get", "AdminNotificationsController@getTableData")->name("notifications.get-list-data");

    Route::resource("notifications", "AdminNotificationsController");
});