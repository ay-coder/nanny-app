<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('booking', 'APIBookingController@index')->name('booking.index');
    Route::post('booking/create', 'APIBookingController@create')->name('booking.create');
    Route::post('booking/edit', 'APIBookingController@edit')->name('booking.edit');
    Route::post('booking/show', 'APIBookingController@show')->name('booking.show');
    Route::post('booking/delete', 'APIBookingController@delete')->name('booking.delete');
});
?>