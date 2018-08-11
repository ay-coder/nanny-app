<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'FrontendController@index')->name('index');

Route::get('support', 'FrontendController@support')->name('support');
Route::get('aboutus', 'FrontendController@aboutus')->name('aboutus');
Route::get('services', 'FrontendController@services')->name('services');
Route::get('contactus', 'FrontendController@contactus')->name('contactus');

Route::get('macros', 'FrontendController@macros')->name('macros');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * Parent Dashboard Specific
         */
        Route::get('parent/home', 'DashboardController@parentIndex')->name('parent.dashboard');

        Route::post('parent/search', 'DashboardController@searchSitters')->name('parent.search');
        Route::get('parent/find/{id}', 'DashboardController@findSitter')->name('parent.findsitter');
        Route::post('parent/booksitter', 'DashboardController@bookSitter')->name('parent.booksitter');
        /*
         * Sitter Dashboard Specific
         */
        Route::get('sitter/home', 'DashboardController@sitterIndex')->name('sitter.dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        Route::get('parent/account', 'AccountController@parentIndex')->name('parent.account');

        Route::get('sitter/account', 'AccountController@sitterIndex')->name('sitter.account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');

        Route::post('parent/update', 'ProfileController@updateParent')->name('parent.update');
        Route::post('parent/babies/update', 'ProfileController@updateBabies')->name('parent.babies.update');
        Route::post('parent/babies/add', 'ProfileController@addBabies')->name('parent.babies.add');
        Route::any('parent/baby/delete/{id}', 'ProfileController@deleteBaby')->name('parent.babies.delete');

        /*
         * Notifications
         */
        Route::get('parent/notification', 'AccountController@parentNotification')->name('parent.notification');

        Route::get('sitter/notification', 'AccountController@sitterNotification')->name('sitter.notification');

        /*
         * Subscription
         */
        Route::get('parent/subscription', 'SubscriptionController@index')->name('parent.subscription');

        /*
         * Appointment
         */
        Route::get('parent/myappointment', 'AppointmentController@index')->name('parent.myappointment');
        Route::get('parent/myappointment/delete/{id}', 'AppointmentController@delete')->name('parent.appointment.delete');
    });
});
