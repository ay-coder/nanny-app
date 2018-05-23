<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('notifications', 'APINotificationsController@index')->name('notifications.index');
    Route::post('notifications/create', 'APINotificationsController@create')->name('notifications.create');
    Route::post('notifications/edit', 'APINotificationsController@edit')->name('notifications.edit');
    Route::post('notifications/show', 'APINotificationsController@show')->name('notifications.show');
    Route::post('notifications/delete', 'APINotificationsController@delete')->name('notifications.delete');
});
?>