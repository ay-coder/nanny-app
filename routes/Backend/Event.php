<?php

Route::group([
    'namespace'  => 'Event',
], function () {

    /*
     * Admin Event Controller
     */
    Route::resource('event', 'AdminEventController');

    Route::get('/', 'AdminEventController@index')->name('event.index');
    Route::get('/get', 'AdminEventController@getTableData')->name('event.get-list-data');
});
