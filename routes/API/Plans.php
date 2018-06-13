<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('plans', 'APIPlansController@index')->name('plans.index');
    Route::post('plans/create', 'APIPlansController@create')->name('plans.create');
    Route::post('plans/edit', 'APIPlansController@edit')->name('plans.edit');
    Route::post('plans/show', 'APIPlansController@show')->name('plans.show');
    Route::post('plans/delete', 'APIPlansController@delete')->name('plans.delete');
});
?>