<?php

namespace App\Http\Middleware;

use App\Traits\HasResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class Authenticate extends LaravelAuthenticate
{
    use HasResponse;
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */

    protected function unauthenticated($request, array $guards)
    {

        if ($request->expectsJson()) {

            return $this->errorResponse('No autorizado', 401);
        }
        # Mensaje de error en caso no estar logueado
        throw new HttpResponseException($this->errorResponse('No autorizado', 401));
    }
}
