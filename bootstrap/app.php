<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Fruitcake\Cors\HandleCors;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api' //themchu api vao trc link
    )
    ->withMiddleware(function (Middleware $middleware) {
       
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
