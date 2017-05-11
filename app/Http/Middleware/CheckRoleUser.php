<?php namespace App\Http\Middleware;
use Closure;
use Redirect;

/**
 * CheckRoleUser
 *
 * @package Middleware to check UserType 2,3
 * @author  <kamal@cara.com.my>
 */
class CheckRoleUser {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	
	
	public function handle($request, Closure $next) { 
		
		//if ($request->user()->user_type == '2') {
		if(in_array($request->user()->user_type, [2,3])){
			return $next($request);
		}
		return Redirect::to('login')->with('success', 'You are not Autherised!');
		
	}
	

}
