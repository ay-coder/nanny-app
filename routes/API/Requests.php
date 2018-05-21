<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('requests', 'APIRequestsController@index')->name('requests.index');
    Route::post('requests/create', 'APIRequestsController@create')->name('requests.create');
    Route::post('requests/edit', 'APIRequestsController@edit')->name('requests.edit');
    Route::post('requests/show', 'APIRequestsController@show')->name('requests.show');
    Route::post('requests/delete', 'APIRequestsController@delete')->name('requests.delete');
});
?>