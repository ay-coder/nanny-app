<?php

Route::group([
    "namespace"  => "Messages",
], function () {
    /*
     * Admin Messages Controller
     */
    
    

    // Route for Ajax DataTable
    Route::get("messages/get", "AdminMessagesController@getTableData")->name("messages.get-list-data");

    Route::resource("messages", "AdminMessagesController");

});
