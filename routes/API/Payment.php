<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('payment', 'APIPaymentController@index')->name('payment.index');
    Route::post('payment-add', 'APIPaymentController@addPayment')->name('payment.add-payment');
    Route::post('payment/create', 'APIPaymentController@create')->name('payment.create');
    Route::post('payment/edit', 'APIPaymentController@edit')->name('payment.edit');
    Route::post('payment/show', 'APIPaymentController@show')->name('payment.show');
    Route::post('payment/delete', 'APIPaymentController@delete')->name('payment.delete');
});
?>