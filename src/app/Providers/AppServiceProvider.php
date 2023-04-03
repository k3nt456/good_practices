<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        #Configuración para tener las migraciones en carpetas,
        $migrationsPath = database_path('migrations'); #Carpeta principal
        $directories    = glob($migrationsPath . '/*', GLOB_ONLYDIR); #Ubicación de los directorios
        $paths          = array_merge([$migrationsPath], $directories); #Se escanea todos los directorios de ambos
        $this->loadMigrationsFrom($paths);

        /* FORMA DE CREAR LAS MIGRACIONES
                *php artisan migrate --path=/database/migrations/posts
                    - De esta manera se crea una carpeta dentro de las migraciones

                *php artisan make:migration create_posts_table --path=/database/migrations/posts
                    - De esta forma de crea una migración en una carpeta ya existente o nueva
        */
    }
}
