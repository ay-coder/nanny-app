<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('messages', 'APIMessagesController@index')->name('messages.index');
    
    Route::get('my-messages', 'APIMessagesController@myMessages')->name('messages.my-message');
    
    Route::post('my-messages/create', 'APIMessagesController@createMyMessage')->name('messages.my-message');

    Route::post('messages/get-chat', 'APIMessagesController@getChat')->name('messages.get-chat');

    Route::post('messages/create', 'APIMessagesController@create')->name('messages.create');
    Route::post('messages/edit', 'APIMessagesController@edit')->name('messages.edit');
    Route::post('messages/show', 'APIMessagesController@show')->name('messages.show');
    Route::post('messages/delete', 'APIMessagesController@delete')->name('messages.delete');
});
?>