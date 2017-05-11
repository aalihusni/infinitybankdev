<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\AnalyticsClass;
use Auth;
use Request;

class MemberAnalytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $exclude = array('chat','assets','check_friend', 'user_info', 'user_online', 'user_is_online');

            $url = Request::url();
            $url = str_replace('http://','',$url);
            $url = str_replace('https://','',$url);
            $url = explode("/",$url);

            if (in_array("members",$url)) {
                if (empty(array_intersect($exclude, $url)))
                {
                    $user_id = Auth::user()->id;
                    AnalyticsClass::addAnalytics($user_id);
                }
            }
        }
        return $next($request);
    }
}
