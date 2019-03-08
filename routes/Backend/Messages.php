<?php

Route::group([
    "namespace"  => "Messages",
], function () {
    /*
     * Admin Messages Controller
     */
    
    // Filter
    Route::get("messages/filter", "AdminMessagesController@filter")->name("messages.filter");

    // Route for Ajax DataTable
    Route::get("messages/get", "AdminMessagesController@getTableData")->name("messages.get-list-data");

    Route::resource("messages", "AdminMessagesController");

});
