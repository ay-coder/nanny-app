<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('general', 'APIGeneralController@index')->name('general.index');
    Route::post('general/create', 'APIGeneralController@create')->name('general.create');
    Route::post('general/edit', 'APIGeneralController@edit')->name('general.edit');
    Route::post('general/show', 'APIGeneralController@show')->name('general.show');
    Route::post('general/delete', 'APIGeneralController@delete')->name('general.delete');
});
?>