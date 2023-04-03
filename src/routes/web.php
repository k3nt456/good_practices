<?php

use Illuminate\Support\Facades\Route;

#Si se intenta acceder en rutas no existentes saldrá el siguiente mensaje
Route::get('/', function () {
    return "Acceso restringido.";
});
