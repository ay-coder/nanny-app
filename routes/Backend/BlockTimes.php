<?php

Route::group([
    "namespace"  => "BlockTimes",
], function () {
    /*
     * Admin BlockTimes Controller
     */

    // Route for Ajax DataTable
    Route::get("blocktimes/get", "AdminBlockTimesController@getTableData")->name("blocktimes.get-list-data");

    Route::resource("blocktimes", "AdminBlockTimesController");
});