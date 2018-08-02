<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('booking', 'APIBookingController@index')->name('booking.index');
    Route::get('past-booking', 'APIBookingController@pastBookings')->name('booking.past');
    Route::post('booking/create', 'APIBookingController@create')->name('booking.create');
    Route::post('booking/edit', 'APIBookingController@edit')->name('booking.edit');
    Route::post('booking/show', 'APIBookingController@show')->name('booking.show');
    Route::post('booking/delete', 'APIBookingController@delete')->name('booking.delete');


    Route::post('booking/accept', 'APIBookingController@accept')->name('booking.accept');
    Route::post('booking/reject', 'APIBookingController@reject')->name('booking.reject');
    Route::post('booking/cancel', 'APIBookingController@cancel')->name('booking.cancel');
    Route::post('booking/cancel-by-sitter', 'APIBookingController@cancelBySitter')->name('booking.cancel');

    Route::post('booking/start', 'APIBookingController@start')->name('booking.start');
    Route::post('booking/stop', 'APIBookingController@stop')->name('booking.stop');
});
?>