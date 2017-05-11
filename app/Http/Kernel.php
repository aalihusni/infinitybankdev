<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \App\Http\Middleware\BlockCountryByIp::class,
        \App\Http\Middleware\SetApplicationLanguage::class,
        \App\Http\Middleware\MemberAnalytics::class,
        \App\Http\Middleware\Secure::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'member' => \App\Http\Middleware\MemberMiddleware::class,
        'secure' => \App\Http\Middleware\Secure::class,
        'role.user' => \App\Http\Middleware\CheckRoleUser::class,
        'roles' => \App\Http\Middleware\CheckRole::class,
    	'VerifyAccessKey'=> \App\Http\Middleware\VerifyAccessKey::class,
    ];
}
