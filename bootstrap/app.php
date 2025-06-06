<?php

use App\Http\Middleware\AuthouriseByRole;
use App\Http\Middleware\AuthouriseRoleByPermission;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Add this line
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // Add CORS middleware globally
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        
         // Register route middleware with alias
         $middleware->alias([
            'role' => AuthouriseByRole::class,
            'permission' => AuthouriseRoleByPermission::class,
            'ensure.valid.access.token' => EnsureTokenIsValid::class,
        ]);

        $middleware->appendToGroup('admin-rights', [
            'ensure.valid.access.token'

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
