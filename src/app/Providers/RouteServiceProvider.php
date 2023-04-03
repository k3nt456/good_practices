<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    #Necesario para no escribir la ruta completa del controlador desde el las rutas de api.php
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            /* EJEMPLO DE COMO USAR EN CASO QUE SE QUIERA TRABAJAR CON TODOS LOS CONTROLADORES SIN CARPETA
            Route::middleware('api')
                #->prefix('api') Se elimina para que no sea el prefijo prestablecido o se cambia por otro que se desee
                ->namespace($this->namespace)#Añadir el la ruta de controller por defecto
                ->prefix('GP')
                ->group(base_path('routes/api.php')); */


            #Autenticación para los controladores
            Route::middleware('api')
                ->namespace($this->namespace)
                ->prefix('GP')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
