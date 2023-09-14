<?php

use Illuminate\Support\Facades\Route;

# MÉTODOS DE LECTURA
Route::middleware('web')->group(
    function () {
        Route::get('/', 'Food\FoodController@index');
    }
);

# MÉTODOS DE ESCRITURA
Route::post('/register', 'Food\FoodController@store');


# MÉTODOS DE EDICIÓN
Route::patch('/{id}', 'Food\FoodController@update');
Route::patch('/delete/{id}', 'Food\FoodController@deleteLogical');

# MÉTODOS DE ELIMINADO
Route::delete('/{id}', 'Food\FoodController@deletePhysical');

Route::fallback(function () {
    return response()->json([
        'message' => 'Acceso restringido.'
    ], 404);
});
