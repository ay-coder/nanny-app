<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('babies', 'APIBabiesController@index')->name('babies.index');
    Route::post('babies/create', 'APIBabiesController@create')->name('babies.create');
    Route::post('babies/edit', 'APIBabiesController@edit')->name('babies.edit');
    Route::post('babies/show', 'APIBabiesController@show')->name('babies.show');
    Route::post('babies/delete', 'APIBabiesController@delete')->name('babies.delete');
});
?>