<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('parents', 'APIParentsController@index')->name('parents.index');
    Route::post('parents/create', 'APIParentsController@create')->name('parents.create');
    Route::post('parents/edit', 'APIParentsController@edit')->name('parents.edit');
    Route::post('parents/show', 'APIParentsController@show')->name('parents.show');
    Route::post('parents/delete', 'APIParentsController@delete')->name('parents.delete');
});
?>