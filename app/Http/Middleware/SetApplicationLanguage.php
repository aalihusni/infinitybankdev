<?php namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetApplicationLanguage {

    public function handle($request, Closure $next)
    {
        App::setLocale(Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));

        return $next($request);
    }

}