<?php

Route::group([
    "namespace"  => "Parents",
], function () {
    /*
     * Admin Parents Controller
     */

    // Route for Ajax DataTable
    Route::get("parents/get", "AdminParentsController@getTableData")->name("parents.get-list-data");

    Route::resource("parents", "AdminParentsController");
});