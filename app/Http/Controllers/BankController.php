<?php

namespace App\Http\Controllers;

use App\Classes\PHGHClass;
use App\Classes\SharesClass;
use App\Classes\BitcoinWalletClass;
use App\User;
use Auth;
use Input;
use Redirect;
use DB;

class BankController extends Controller
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

    public function provide_help($from, $value_in_btc, $secret)
    {
        if ($value_in_btc > 0) {
            $user = Auth::user();
            $user_id = $user->id;

            if ($user->user_type == 3)
            {
                return Redirect::back()->withErrors("User is not eligible to 'Provide Help' !");
            }

            if ($from == "bitcoin") {
                $type = "queue";

                $ph_status = PHGHClass::createPH($user_id, $value_in_btc, $type, $secret);
            } else {
                $type = "active";

                return Redirect::back()->withErrors("You no longer can 'Provide Help' using 'Shares'. You must 'Provide Help' using 'Bitcoin' !");
                /*
                $shares_balance = SharesClass::getSharesBalance($user_id);
                if ($shares_balance['shares_balance'] < $value_in_btc) {
                    return Redirect::back()->withErrors('Insufficient shares balance !');
                }

                $ph = PHGHClass::getPHAll($user_id, "3", ">=");
                if (!count($ph))
                {
                    return Redirect::back()->withErrors("You must 'Provide Help' using Bitcoin before you can 'Provide Help' using Shares");
                }

                $ph_status = PHGHClass::createPH($user_id, $value_in_btc, $type);
                if (!isset($ph_status['error']))
                {
                    SharesClass::setShares($user_id, "PH", $ph_status, $user_id, 0, -$value_in_btc);
                }
                */
            }

            if (isset($ph_status['error'])) return Redirect::route($ph_status['redirect'])->withErrors($ph_status['error']);

            return Redirect::route('provide-help');
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }

    public function provide_help_cancel($ph_id, $secret)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $status = 8;

        $ph = PHGHClass::getPH($ph_id);

        if ($ph['user_id'] <> $user_id)
        {
            // Trying to cancel other user GH
            return Redirect::back()->withErrors('Invalid PH (No Access) !');
        }

        if ($ph['status'] > 0)
        {
            return Redirect::back()->withErrors("This PH Can't Be Canceled");
        }

        DB::beginTransaction();

        PHGHClass::setPH($ph_id, $status);

        DB::commit();

        return Redirect::route('provide-help');
    }

    public function get_help($from, $value_in_btc, $secret)
    {
        if ($value_in_btc > 0) {
            $user = Auth::user();
            $user_id = $user->id;

            $ph = PHGHClass::getPHAll($user_id, "3", ">=");
            if (!count($ph))
            {
                return Redirect::back()->withErrors("You must 'Provide Help' before you can 'Get Help' !");
            }

            if ($user->user_type == 3)
            {
                return Redirect::back()->withErrors("User is not eligible to 'Get Help' !");
            }

            $shares_balance = SharesClass::getSharesBalance($user_id);
            if ($shares_balance['shares_balance'] < $value_in_btc) {
                return Redirect::back()->withErrors('Insufficient shares balance !');
            }

            DB::beginTransaction();
            $gh_status = PHGHClass::createGH($user_id, $value_in_btc, $secret);
            if (!isset($gh_status['error']))
            {
                SharesClass::setShares($user_id, $secret, "GH", $gh_status, $user_id, 0, -$value_in_btc);
            }
            DB::commit();

            if (isset($gh_status['error'])) return Redirect::route($gh_status['redirect'])->withErrors($gh_status['error']);

            return Redirect::route('get-help');
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }

    public function get_help_cancel($gh_id, $secret)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $status = 8;

        $gh = PHGHClass::getGH($gh_id);

        if ($gh['user_id'] <> $user_id)
        {
            // Trying to cancel other user GH
            return Redirect::back()->withErrors('Invalid GH (No Access) !');
        }

        if ($gh['status'] > 0)
        {
            return Redirect::back()->withErrors("This GH Can't Be Canceled");
        }

        DB::beginTransaction();

        $shares_type = "GH-CANCELED";
        $shares_type_id = $gh['id'];
        $shares_type_user_id = $user_id;
        $shares_type_percent = "";
        $value_in_btc = $gh['value_in_btc'];

        PHGHClass::setGH($gh_id, $status);
        SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $shares_type_user_id, $shares_type_percent, $value_in_btc);

        DB::commit();

        return Redirect::route('get-help');
    }

    public function ph_release($type, $ph_id, $value_in_btc, $secret)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $ph = PHGHClass::getPH($ph_id);

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

        PHGHClass::releasePH($type, $ph_id, $value_in_btc, $secret);

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
        $status = PHGHClass::getPHGH($id)['status'];

        echo $status;
    }
}
