<?php

Route::group([
    'namespace'  => 'Event',
], function () {

    /*
     * Admin Event Controller
     */
    Route::resource('event', 'EventController');

    Route::get('/', 'EventController@index')->name('event.index');
    Route::get('/get', 'EventController@getTableData')->name('event.get-list-data');
});
