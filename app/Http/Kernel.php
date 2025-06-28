<?php

   namespace App\Http;

   use Illuminate\Foundation\Http\Kernel as HttpKernel;

   class Kernel extends HttpKernel
   {
       protected $middleware = [
           \Illuminate\Http\Middleware\HandleCors::class,
           \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
           \Illuminate\Http\Middleware\ValidatePostSize::class,
           \App\Http\Middleware\TrimStrings::class,
           \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
       ];

       protected $middlewareGroups = [
           'web' => [
               \App\Http\Middleware\EncryptCookies::class,
               \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
               \Illuminate\Session\Middleware\StartSession::class,
               \Illuminate\View\Middleware\ShareErrorsFromSession::class,
               \Illuminate\Routing\Middleware\SubstituteBindings::class,
               \App\Http\Middleware\VerifyCsrfToken::class,
           ],

           'api' => [
               'throttle:api',
               \Illuminate\Routing\Middleware\SubstituteBindings::class,
           ],
       ];

       protected $routeMiddleware = [
           'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
           'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
           'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
           'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
           'can' => \Illuminate\Auth\Middleware\Authorize::class,
           'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
           'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
           'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
           'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
           'admin' => \App\Http\Middleware\AdminMiddleware::class, // PASTIKAN INI ADA
       ];
   }
   