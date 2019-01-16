<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::any('dashboard', 'DashboardController@index')->name('dashboard');

Route::any('push-notifications', 'DashboardController@sendPushNotifications')->name('push-notifications');
