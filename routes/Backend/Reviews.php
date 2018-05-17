<?php

Route::group([
    "namespace"  => "Reviews",
], function () {
    /*
     * Admin Reviews Controller
     */

    // Route for Ajax DataTable
    Route::get("reviews/get", "AdminReviewsController@getTableData")->name("reviews.get-list-data");

    Route::resource("reviews", "AdminReviewsController");
});