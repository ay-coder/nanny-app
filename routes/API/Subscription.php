<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('subscription', 'APISubscriptionController@index')->name('subscription.index');
    Route::post('subscription/create', 'APISubscriptionController@create')->name('subscription.create');
    Route::post('subscription/edit', 'APISubscriptionController@edit')->name('subscription.edit');
    Route::post('subscription/show', 'APISubscriptionController@show')->name('subscription.show');
    Route::post('subscription/delete', 'APISubscriptionController@delete')->name('subscription.delete');
});
?>