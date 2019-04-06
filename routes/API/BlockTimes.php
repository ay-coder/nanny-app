<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('blocktimes', 'APIBlockTimesController@index')->name('blocktimes.index');
    Route::post('blocktimes/create', 'APIBlockTimesController@create')->name('blocktimes.create');
    Route::post('blocktimes/edit', 'APIBlockTimesController@edit')->name('blocktimes.edit');
    Route::post('blocktimes/show', 'APIBlockTimesController@show')->name('blocktimes.show');
    Route::post('blocktimes/delete', 'APIBlockTimesController@delete')->name('blocktimes.delete');
});
?>