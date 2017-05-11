<?php

namespace App\Http\Controllers;

use App\Classes\PassportClass;
use Auth;

class PassportController extends Controller
{
    public function __construct()
    {
        $this->middleware('member', ['except' => 'blockio-passport']);
    }

    public function blockio_passport($quantity)
    {
        $user_id = Auth::user()->id;
        $get_payment_details = PassportClass::getPaymentDetails($user_id, $quantity);

        return $get_payment_details['receiving_address'];
    }

    public function passport_price($quantity)
    {
        $calc_passport_discount = PassportClass::calcPassportDiscount($quantity);

        echo json_encode($calc_passport_discount);
    }
}