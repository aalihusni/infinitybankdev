<?php namespace App\Http\Middleware;
use Closure;
use Redirect;

/**
 * CheckRole
 *
 * @package  Middleware
 * @author   Cara <kamal@cara.com.my>
 */
class CheckRole {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($request->user()->user_type == '1' || $request->user()->leader_at != '0000-00-00 00:00:00') {
			return $next($request);
		}
		return Redirect::to('login')->with('success', 'You are not Autherised!');
	}

}
