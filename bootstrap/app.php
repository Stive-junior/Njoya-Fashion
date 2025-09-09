<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 🌐 Middleware globaux (issus de Kernel.php - section $middleware)
        $middleware->append([
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            // PreventRequestsDuringMaintenance et TrimStrings sont commentés dans ton Kernel.php
        ]);

        // 🧁 Middleware groupe web (issus de Kernel.php - section $middlewareGroups['web'])
        $middleware->web([
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // EncryptCookies et VerifyCsrfToken sont commentés dans ton Kernel.php
            // NoCache n'était pas dans le Kernel.php fourni dans ce prompt.
        ]);

        // 🔒 Middleware groupe API (issus de Kernel.php - section $middlewareGroups['api'])
        $middleware->api([
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // EnsureFrontendRequestsAreStateful est commenté dans ton Kernel.php
        ]);

        // 🔑 Middlewares nommés (alias) (issus de Kernel.php - section $middlewareAliases)
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'is.manager' => \App\Http\Middleware\IsManager::class,
            'is.custom' => \App\Http\Middleware\IsCustomer::class,
            'no.cache' => \App\Http\Middleware\NoCache::class,
            // 'signed' est commenté dans ton Kernel.php
            // Les autres alias des modules Core ne sont pas présents dans le Kernel.php fourni dans ce prompt.
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();