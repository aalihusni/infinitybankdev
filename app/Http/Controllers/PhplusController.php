<?php

namespace App\Http\Controllers;

use App\Classes\PHGHClass;
use App\Classes\SharesClass;
use App\User;
use Auth;
use Input;
use Redirect;

class PhplusController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    /*
     * #PH @ GH
     * 0 = queue
     * 1 = assign partial & queue
     * 2 = assign full
     * 3 = active / completed
     * 4 = on hold
     * 5 = released
     * 6 = cancel / ended
     */

    /*
     * #PHGH
     * 0 = pending
     * 1 = waiting confirmation
     * 2 = confirmed / completed
     * 3 = expired
     */

    public function provide_help($value_in_btc)
    {
        if ($value_in_btc > 0) {
            $user = Auth::user();
            $user_id = $user->id;

            if ($user->user_type == 3) {
                return Redirect::back()->withErrors("User is not eligible to 'Provide Help Plus' !");
            }

            $total_ph_active = PHGHClass::getPHTotal($user_id, "5", "<=", 1);
            if ($total_ph_active['active'] <= 0) {
                return Redirect::back()->withErrors("User is not eligible to 'Provide Help Plus' !");
            }

            if ($value_in_btc > $total_ph_active['active']) {
                return Redirect::back()->withErrors("You cannot PH+ more than your Region Bank Active PH");
            }

            $type = "plus";
            $ph_status = PHGHClass::createPH($user_id, $value_in_btc, $type, $secret);

            if (isset($ph_status['error'])) return Redirect::route($ph_status['redirect'])->withErrors($ph_status['error']);

            return Redirect::route('ph-plus');
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }
}