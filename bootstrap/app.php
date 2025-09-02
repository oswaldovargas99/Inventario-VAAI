<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// --- Auto-detección del namespace correcto de Spatie ---
$RoleMiddlewareClass = class_exists(\Spatie\Permission\Middlewares\RoleMiddleware::class)
    ? \Spatie\Permission\Middlewares\RoleMiddleware::class
    : \Spatie\Permission\Middleware\RoleMiddleware::class;

$PermissionMiddlewareClass = class_exists(\Spatie\Permission\Middlewares\PermissionMiddleware::class)
    ? \Spatie\Permission\Middlewares\PermissionMiddleware::class
    : \Spatie\Permission\Middleware\PermissionMiddleware::class;

$RoleOrPermissionMiddlewareClass = class_exists(\Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class)
    ? \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class
    : \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) use (
        $RoleMiddlewareClass,
        $PermissionMiddlewareClass,
        $RoleOrPermissionMiddlewareClass
    ) {
        // Aliases para usar role:, permission:, role_or_permission:
        $middleware->alias([
            'role' => $RoleMiddlewareClass,
            'permission' => $PermissionMiddlewareClass,
            'role_or_permission' => $RoleOrPermissionMiddlewareClass,
        ]);

        // Si tienes otros grupos de middleware personalizados, revisa también su orden.

    })
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,   // si lo usas
        App\Providers\JetstreamServiceProvider::class, // si lo usas
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();