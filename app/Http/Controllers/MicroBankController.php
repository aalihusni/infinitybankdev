<?php

namespace App\Http\Controllers;

use App\Classes\MicroPHGHClass;
use App\Classes\MicroSharesClass;
use App\User;
use Auth;
use Input;
use Redirect;

class MicroBankController extends Controller
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

    public function provide_help($from, $value_in_btc)
    {
        if ($value_in_btc > 0) {
            $user = Auth::user();
            $user_id = $user->id;

            if ($user->user_type == 3)
            {
                return Redirect::back()->withErrors("User is not eligible to 'Micro Provide Help' !");
            }

            if ($from == "bitcoin") {
                $type = "queue";

                $ph_status = MicroPHGHClass::createPH($user_id, $value_in_btc, $type);
            } else {
                return Redirect::back()->withErrors("You must 'Micro Provide Help' using Bitcoin");
            }

            if ($value_in_btc > 0.5)
            {
                return Redirect::back()->withErrors("Invalid value !");
            }

            if (isset($ph_status['error'])) return Redirect::route($ph_status['redirect'])->withErrors($ph_status['error']);

            return Redirect::route('micro-provide-help');
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }

    public function get_help($from, $value_in_btc)
    {
        if ($value_in_btc > 0) {
            $user = Auth::user();
            $user_id = $user->id;

            $ph = MicroPHGHClass::getPHAll($user_id, "3", ">=");
            if (!count($ph))
            {
                return Redirect::back()->withErrors("You must 'Micro Provide Help' before you can 'Micro Get Help' !");
            }

            if ($user->user_type == 3)
            {
                return Redirect::back()->withErrors("User is not eligible to 'Micro Get Help' !");
            }

            if ($value_in_btc > 0.5)
            {
                return Redirect::back()->withErrors("Invalid value !");
            }

            $shares_balance = MicroSharesClass::getSharesBalance($user_id);
            if ($shares_balance['shares_balance'] < $value_in_btc) {
                return Redirect::back()->withErrors('Insufficient shares balance !');
            }

            $gh_status = MicroPHGHClass::createGH($user_id, $value_in_btc);
            if (!isset($gh_status['error']))
            {
                MicroSharesClass::setShares($user_id, "MGH", $gh_status, $user_id, 0, -$value_in_btc);
            }

            if (isset($gh_status['error'])) return Redirect::route($gh_status['redirect'])->withErrors($gh_status['error']);

            return Redirect::route('micro-get-help');
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }

    public function ph_release($type, $ph_id, $value_in_btc)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $ph = MicroPHGHClass::getPH($ph_id);

        if ($ph['user_id'] <> $user_id)
        {
            // Trying to release other user PH
            return Redirect::back()->withErrors('Invalid PH (No Access) !');
        }
        if ($ph['status'] <> 3)
        {
            // Trying to release not active PH
            return Redirect::back()->withErrors('Invalid PH ('.$ph['status'].') !');
        }
        if ($ph['day'] < 20)
        {
            // Trying to release not matured PH
            return Redirect::back()->withErrors('Invalid PH (Not Matured) !');
        }
        if ($type == "profit" && $value_in_btc > $ph['dividen_now_in_btc'])
        {
            // Trying to release insufficient PH
            return Redirect::back()->withErrors('Insufficient PH Share value !');
        }

        MicroPHGHClass::releasePH($type, $ph_id, $value_in_btc);

        return Redirect::back();
    }

    public function pair_move($position)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->pair_move = $position;
        $user->save();

        return Redirect::back();
    }

    public function phgh_status($id)
    {
        $status = MicroPHGHClass::getPHGH($id)['status'];

        echo $status;
    }
}
