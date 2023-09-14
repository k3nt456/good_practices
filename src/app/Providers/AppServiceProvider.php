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
        #Configuración para tener las migraciones en carpetas
        $migrationsPath = database_path('migrations');
        $this->loadMigrationsFromDirectory($migrationsPath);
    }

    protected function loadMigrationsFromDirectory(string $path): void
    {
        /* FORMA DE CREAR LAS MIGRACIONES
                *php artisan migrate --path=/database/migrations/posts
                    - De esta manera se crea una carpeta dentro de las migraciones

                *php artisan make:migration create_posts_table --path=/database/migrations/posts
                    - De esta forma de crea una migración en una carpeta ya existente o nueva
        */

        $this->loadMigrationsFrom($path);

        foreach (glob($path . '/*', GLOB_ONLYDIR) as $directory) {
            $this->loadMigrationsFromDirectory($directory);
        }
    }
}
