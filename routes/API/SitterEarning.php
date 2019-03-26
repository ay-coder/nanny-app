<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('sitterearning', 'APISitterEarningController@index')->name('sitterearning.index');
    Route::post('sitterearning/create', 'APISitterEarningController@create')->name('sitterearning.create');
    Route::post('sitterearning/edit', 'APISitterEarningController@edit')->name('sitterearning.edit');
    Route::post('sitterearning/show', 'APISitterEarningController@show')->name('sitterearning.show');
    Route::post('sitterearning/delete', 'APISitterEarningController@delete')->name('sitterearning.delete');
});
?>