<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    // inicio do bloco registrar_middleware ...
    ->withMiddleware(function (Middleware $middleware) {
        
        // Aqui registramos o apelido 'is_master' apontando para a classe que criamos
        $middleware->alias([
            'is_master' => \App\Http\Middleware\IsMaster::class,
        ]);
        
    })
    // do bloco registrar_middleware.
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();