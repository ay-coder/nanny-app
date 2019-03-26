<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('sitterbooking', 'APISitterBookingController@index')->name('sitterbooking.index');
    Route::post('sitterbooking/create', 'APISitterBookingController@create')->name('sitterbooking.create');
    Route::post('sitterbooking/edit', 'APISitterBookingController@edit')->name('sitterbooking.edit');
    Route::post('sitterbooking/show', 'APISitterBookingController@show')->name('sitterbooking.show');
    Route::post('sitterbooking/delete', 'APISitterBookingController@delete')->name('sitterbooking.delete');
});
?>