<?php

use Illuminate\Support\Facades\Route;


Route::post('/login', 'AuthController@login')->name('login');
    // Route::post('/me', 'AuthController@me');
    // Route::post('/logout', 'AuthController@logout');
    // Route::post('/refresh', 'AuthController@refresh');
    // Route::post('/resend_credentials', 'AuthController@resendCredentials');
    // Route::get('/validateToken', 'AuthController@validateToken');
