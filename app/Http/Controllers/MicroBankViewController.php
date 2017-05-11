<?php

namespace App\Http\Controllers;

use App\Classes\MicroPHGHClass;
use App\Classes\UserClass;
use App\Classes\PairClass;
use App\Classes\BlockioWalletClass;
use Auth;
use Crypt;
use Carbon\Carbon;

class MicroBankViewController extends Controller
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

    public function provide_help()
    {
        $user_id = Auth::user()->id;
        $user_details = UserClass::getUserDetails($user_id);
        $ph_active = MicroPHGHClass::getPHAll($user_id, "5", "<=");
        $ph_ended = MicroPHGHClass::getPHAll($user_id, "6", ">=");
        $total_ph_active = MicroPHGHClass::getPHTotal($user_id, "5", "<=");

        return view('member.micro_provide_help')->with('user_details', $user_details)->with('ph_active', $ph_active)->with('ph_ended', $ph_ended)->with('total_ph_active', $total_ph_active);
    }

    public function get_help()
    {
        $user_id = Auth::user()->id;
        $user_details = UserClass::getUserDetails($user_id);
        $gh_active = MicroPHGHClass::getGHAll($user_id, "5", "<=");
        $gh_ended = MicroPHGHClass::getGHAll($user_id, "6");
        $total_gh_active = MicroPHGHClass::getGHTotal($user_id, "5", "<=");

        return view('member.micro_get_help')->with('user_details', $user_details)->with('gh_active', $gh_active)->with('gh_ended', $gh_ended)->with('total_gh_active', $total_gh_active);
    }

    public function pairing()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $pair_move = $user->pair_move;
        switch ($user->user_class)
        {
            case 3:
                $percent = 0.5;
                break;
            case 4:
                $percent = 1;
                break;
            case 5:
                $percent = 3;
                break;
            case 6:
                $percent = 5;
                break;
            case 7:
                $percent = 7;
                break;
            case 8:
                $percent = 10;
                break;
            default:
                $percent = 0;
        }
        $pair = PairClass::getCurrentPair($user_id, $pair_move);
        $bonus_amount = number_format(($pair['pair'] / 100) * $percent,8);
        if ($pair_move == 1)
        {
            $selected[1] = "panel panel-primary";
            $selected[2] = "panel panel-featured panel-featured-dark";
            $selected[3] = "panel panel-featured panel-featured-dark";
        }
        elseif ($pair_move == 3)
        {
            $selected[1] = "panel panel-featured panel-featured-dark";
            $selected[2] = "panel panel-featured panel-featured-dark";
            $selected[3] = "panel panel-primary";
        } else {
            $selected[1] = "panel panel-featured panel-featured-dark";
            $selected[2] = "panel panel-primary";
            $selected[3] = "panel panel-featured panel-featured-dark";
        }
        $pair_history = PairClass::pairHistory($user_id);

        return view('member.pairing')->with('pair', $pair)->with('selected', $selected)->with('percent', $percent)->with('bonus_amount', $bonus_amount)->with('pair_history', $pair_history);
    }

    public function ajax_phgh($phgh_id)
    {
        $get_payment_details = MicroPHGHClass::getPHPaymentDetails($phgh_id);
        $cryptid = Crypt::encrypt($get_payment_details['sender_user_id']);

        //$get_payment_details['receiving_address']    = $phgh_id;
        //$get_payment_details['value_in_btc']         = "0.01";
        //MicroPHGHClass::setPHGH($phgh_id,2);

        $address_created_at = BlockioWalletClass::getWalletReceivingDetails($get_payment_details['receiving_address'])['created_at'];

        //Get time elapse
        $time_now = Carbon::now();
        $time_lock = Carbon::createFromFormat('Y-m-d H:i:s', $address_created_at);
        $diff_min = $time_now->diffInMinutes($time_lock);
        $diff_sec = $time_now->diffInSeconds($time_lock);

        //Get time left
        if ($diff_sec < 5) {
            $time_left['min'] = 14;
            $time_left['sec'] = 59;
        } else {
            $diff_min_sec = $diff_sec - ($diff_min * 60);
            $min_left = 15 - ceil(($diff_sec / 60));
            $sec_left = ((15 * 60) - $diff_sec) - ($min_left * 60);
            if ($min_left == 15 || $min_left < 0) $min_left = 14;
            if ($sec_left == 60 || $sec_left < 0) $sec_left = 59;
            $time_left['min'] = $min_left;
            $time_left['sec'] = $sec_left;
        }

        return view('ajax.phgh')->with('get_payment_details', $get_payment_details)->with('cryptid', $cryptid)->with('time_left', $time_left);
    }
}
