<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('activation', 'APIActivationController@index')->name('activation.index');
    
    Route::post('get-my-activation', 'APIActivationController@getMyActivation')->name('activation.get-my-activation');

    Route::post('activation/create', 'APIActivationController@create')->name('activation.create');
    Route::post('activation/edit', 'APIActivationController@edit')->name('activation.edit');
    Route::post('activation/show', 'APIActivationController@show')->name('activation.show');
    Route::post('activation/delete', 'APIActivationController@delete')->name('activation.delete');
});
?>