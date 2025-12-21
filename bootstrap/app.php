<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan alias 'admin' ke Middleware IsAdmin kamu
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        
        // Exclude Midtrans Webhook from CSRF
        $middleware->validateCsrfTokens(except: [
            'midtrans-callback', 
            '/midtrans-callback'
        ]);
        // --------------------------
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();