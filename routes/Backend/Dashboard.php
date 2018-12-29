<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::any('dashboard', 'DashboardController@index')->name('dashboard');
