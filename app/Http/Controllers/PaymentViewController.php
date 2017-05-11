<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\PaymentClass;
use Auth;
use Redirect;

class PaymentViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function confirm()
    {
        $user_id = Auth::user()->id;
        $transaction = PaymentClass::getPendingTransaction($user_id);

        if ($transaction) {
            return view('member.payment_confirmation')->with('transaction', $transaction);
        } else {
            return Redirect::route('home');
        }
    }

}
