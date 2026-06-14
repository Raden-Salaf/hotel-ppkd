<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // daftar middleware kasih code disini
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'no-cache' => \App\Http\Middleware\NoCache::class,
        ]);
        // append NoCache middleware to the web group so authenticated pages are not cached
        $middleware->web(append: [\App\Http\Middleware\NoCache::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
