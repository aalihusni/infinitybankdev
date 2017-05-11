<?php

namespace App\Http\Middleware;

use Closure;
use URL;
use Request;


class Secure
{
	
	public function handle($request, Closure $next)
	{

		//if (env('APP_DEBUG') == false)
		//{
			URL::forceSchema('https');
		//}
		
		return $next($request);
	}
	
}