<?php

use Illuminate\Support\Facades\Route;

/* MÉTODOS DE LECTURA */
Route::middleware('web')->group(
    function () {
        Route::get('/', 'Users\UserClientController@indexAuth');
    }
);

/* MÉTODOS DE ESCRITURA */
Route::post('/', 'Users\UserClientController@store');
