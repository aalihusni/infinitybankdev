<?php

namespace App\Http\Controllers;

use App\Classes\MicroPassportClass;
use Auth;

class MicroPassportController extends Controller
{
    public function __construct()
    {
        $this->middleware('member', ['except' => 'blockio-micro-passport']);
    }

    public function blockio_passport($quantity)
    {
        $user_id = Auth::user()->id;
        $get_payment_details = MicroPassportClass::getPaymentDetails($user_id, $quantity);

        return $get_payment_details['receiving_address'];
    }

    public function passport_price($quantity)
    {
        $calc_passport_discount = MicroPassportClass::calcPassportDiscount($quantity);

        echo json_encode($calc_passport_discount);
    }
}