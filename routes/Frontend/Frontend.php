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
        Route::get('sitter/home', 'JobsController@index')->name('sitter.dashboard');

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

        Route::post('sitter/update', 'ProfileController@updateSitter')->name('sitter.update');

        /*
         * Notifications
         */
        Route::get('parent/notification', 'AccountController@parentNotification')->name('parent.notification');

        Route::get('sitter/notification', 'AccountController@sitterNotification')->name('sitter.notification');
        Route::get('sitter/earning', 'AccountController@sitterEarnings')->name('sitter.earning');
        Route::get('sitter/vacation', 'AccountController@vacationMode')->name('sitter.vacation');
        Route::post('sitter/changevacation', 'AccountController@changeVacationMode')->name('sitter.changevacation');

        /*
         * Subscription
         */
        Route::get('parent/subscription', 'SubscriptionController@index')->name('parent.subscription');
        Route::post('parent/plansubscription', 'SubscriptionController@subscribePlan')->name('parent.plansubscription');
        

        Route::post('parent/add-message', 'SubscriptionController@addMessage')->name('parent.add-message');



        /*
         * Appointment
         */
        Route::get('parent/myappointment', 'AppointmentController@index')->name('parent.myappointment');
        Route::post('parent/appointment/payment', 'AppointmentController@bookingPayment')->name('parent.bookingpayment');
        Route::get('parent/previous/{booking_id}', 'AppointmentController@previousParentBooking')->name('parent.previousbooking');
        Route::get('parent/booking/{booking_id}', 'AppointmentController@ParentBookingdetails')->name('parent.bookingdetails');
        Route::get('parent/myappointment/{id}/delete', 'AppointmentController@delete')->name('parent.appointment.delete');

        Route::get('booking/{booking_id}/accept', 'AppointmentController@accept')->name('sitter.booking.accept');
        Route::get('booking/{booking_id}/reject', 'AppointmentController@reject')->name('sitter.booking.reject');
        Route::get('booking/{booking_id}', 'AppointmentController@getBooking')->name('sitter.booking');

        Route::get('sitter/my-jobs', 'JobsController@index')->name('sitter.myjobs');
        Route::get('job/{job_id}/start', 'JobsController@start')->name('sitter.job.start');
        Route::get('job/{job_id}/stop', 'JobsController@stop')->name('sitter.job.stop');
        Route::get('job/{job_id}/cancel', 'JobsController@cancel')->name('sitter.job.cancel');

        /**
         * Reviews
         */
        Route::post('reviews/create', 'ReviewsController@create')->name('parent.reviews.create');
    });
});
