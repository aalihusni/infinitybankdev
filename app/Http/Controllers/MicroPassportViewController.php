<?php

namespace App\Http\Controllers;

use App\Classes\MicroPassportClass;
use App\Classes\BlockioWalletClass;
use Auth;
use Carbon\Carbon;

class MicroPassportViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $passport_details = MicroPassportClass::getPassportDetails($user_id);
        $passport_transactions = MicroPassportClass::getPassportTransactions($user_id);
        $waiting_confirmations = MicroPassportClass::getWaitingConfirmations($user_id);

        return view('member.micro_passport')->with('passport_details', $passport_details)->with('passport_transactions', $passport_transactions)->with('waiting_confirmations', $waiting_confirmations);
    }

    public function ajax_passport($quantity)
    {
        $user_id = Auth::user()->id;
        $get_payment_details['quantity'] = $quantity;
        $get_payment_details = MicroPassportClass::getPaymentDetails($user_id, $quantity);
        $address_created_at = BlockioWalletClass::getWalletReceivingDetails($get_payment_details['receiving_address'])['created_at'];

        if (!empty($address_created_at)) {
            //Get time elapse
            $time_now = Carbon::now();
            $time_lock = Carbon::createFromFormat('Y-m-d H:i:s', $address_created_at);
            $diff_min = $time_now->diffInMinutes($time_lock);
            $diff_sec = $time_now->diffInSeconds($time_lock);
        } else {
            $diff_min = 0;
            $diff_sec = 0;
        }

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

        return view('ajax.micro_passport')->with('get_payment_details', $get_payment_details)->with('time_left', $time_left);
    }
}
