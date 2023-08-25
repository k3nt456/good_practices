<?php

use Illuminate\Support\Facades\Route;

# Rutas de autenticación
Route::group(['prefix' => 'auth'], function () {
    require __DIR__ . '/Authentication/Authentication.php';
});

# Ruta de usuarios tipo cliente
Route::group(['prefix' => 'client'], function () {
    require __DIR__ . '/Users/Client.php';
});

# Ruta de alimentos
Route::group(['prefix' => 'food'], function () {
    require __DIR__ . '/Food/Food.php';
});


# Si se intenta acceder en rutas no existentes saldrá el siguiente mensaje
Route::fallback(function () {
    return response()->json([
        'message' => 'Acceso restringido.'
    ], 404);
});
