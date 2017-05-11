<?php

namespace App\Http\Controllers;

use Auth;
use App\Classes\PAGBClass;

class PAGBController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function check_upline($alias, $upline_user_id = "")
    {
        $empty_slot = PAGBClass::getEmptyTreeSlot($alias, $upline_user_id);
        echo json_encode($empty_slot);
    }
}