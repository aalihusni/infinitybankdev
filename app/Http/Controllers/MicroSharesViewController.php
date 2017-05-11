<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\MicroSharesClass;
use Auth;

class MicroSharesViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $wallet_address = $user->wallet_address;
        $shares_transactions = MicroSharesClass::getSharesTransactions($user_id);
        $shares_balance = MicroSharesClass::getSharesBalance($user_id);
        $shares_balance_type = MicroSharesClass::getSharesBalanceTypeAll($user_id);

        return view('member.micro_shares')->with('wallet_address', $wallet_address)->with('shares_transactions', $shares_transactions)->with('shares_balance', $shares_balance)->with('shares_balance_type', $shares_balance_type);
    }
}
