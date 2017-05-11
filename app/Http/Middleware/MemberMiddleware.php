<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App\Classes\BitcoinWalletClass;

class MemberMiddleware
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
        if(!Auth::check())
        {
            Auth::logout();
            return Redirect::to('login')->with('success', 'You are not logged in!');
        }
        elseif(!Auth::user()->firstname || !Auth::user()->lastname || !Auth::user()->country_code)
        {
            if (Auth::user()->id <> 1) {
                return Redirect::to('complete-profile');
            }
        }
        if(Auth::user()->is_dispute)
        {
            return Redirect::to('members/dispute');
        }
        if(!BitcoinWalletClass::validBitcoinAddress(Auth::user()->wallet_address))
        {
            if ($request->segment(1) == "members")
            {
                if (!($request->segment(2) == "bitcoin-wallet" || $request->segment(2) == "update-wallet")) {
                    return Redirect::to('members/bitcoin-wallet')->withErrors("Please update your wallet address !");
                }
            }

        }
        return $next($request);
    }
}
