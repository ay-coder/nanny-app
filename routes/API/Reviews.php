<?php
Route::group(['namespace' => 'Api'], function()
{
    Route::get('reviews', 'APIReviewsController@index')->name('reviews.index');
    Route::post('reviews/create', 'APIReviewsController@create')->name('reviews.create');
    Route::post('reviews/edit', 'APIReviewsController@edit')->name('reviews.edit');
    Route::post('reviews/show', 'APIReviewsController@show')->name('reviews.show');
    Route::post('reviews/delete', 'APIReviewsController@delete')->name('reviews.delete');
});
?>