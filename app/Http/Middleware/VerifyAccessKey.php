<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccessKey
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
    	$key = $request->api_key; 
    	//if($key == env('API_KEY', 'lgEaqBP9bPWM2ANYevGzj5O81GS15TWG'))
    	if($key == 'lgEaqBP9bPWM2ANYevGzj1234GS15TWG')
    		return $next($request);
    	else 
    		return response()->json(['error' => 'unauthorized' ], 401);
    }
}
