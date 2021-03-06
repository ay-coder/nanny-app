<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('sitters', 'APISittersController@index')->name('sitters.index');

    Route::post('find-sitters', 'APISittersController@findSitters')->name('sitters.index');
    Route::post('sitters/create', 'APISittersController@create')->name('sitters.create');
    Route::post('sitters/edit', 'APISittersController@edit')->name('sitters.edit');
    Route::post('sitters/show', 'APISittersController@show')->name('sitters.show');
    Route::post('sitters/delete', 'APISittersController@delete')->name('sitters.delete');

    Route::get('sitters/calendar', 'APISittersController@getMyCalendar')->name('sitters.calendar');

    Route::post('sitters/vacation', 'APISittersController@vacationMode')->name('sitters.vacation');

    Route::get('sitters/active-bookings', 'APISittersController@activeBookings')->name('sitters.active-bookings');

    Route::get('sitters/past-bookings', 'APISittersController@pastBookings')->name('sitters.past-bookings');

    Route::post('sitters/get-booking', 'APISittersController@getBooking')->name('sitters.get-booking');

    Route::post('sitters/add-timings', 'APISittersController@addTimings')->name('sitters.add-timings');

    Route::get('sitters/my-earnings', 'APISittersController@myEarnings')->name('sitters.my-earnings');

});
?>