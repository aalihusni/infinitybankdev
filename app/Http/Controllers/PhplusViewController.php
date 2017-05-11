<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\Classes\UserClass;
use App\Classes\PHGHClass;
use App\Classes\PHPlusClass;
use Input;
use Auth;
use Carbon\Carbon;
use Redirect;

class PhplusViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $user_details = UserClass::getUserDetails($user_id);
        $ph_active = PHGHClass::getPHAll($user_id, "5", "<=", "plus");
        $ph_ended = PHGHClass::getPHAll($user_id, "6", ">=", "plus");
        $total_ph_active = PHGHClass::getPHTotal($user_id, "5", "<=", 1);
        $total_ph_plus_active = PHGHClass::getPHTotal($user_id, "5", "<=", 3);
        $total_ph_needed = ($total_ph_plus_active['active'] * 5);

        if (empty(count($ph_active)))
        {
            return Redirect::back();
        }

        $requirement['total_recruitment'] = 0;
        $requirement['total_ph_active'] = 0;
        $requirement['recruitment'] = "";

        if (count($ph_active)) {
            foreach ($ph_active as $ph) {
                if ($ph['status'] == 3) {
                    $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $ph['time_on_hold']);
                    $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $ph['time_on_hold'])->addDays(30);
                    $requirement = PHPlusClass::getRecruitment($user_id, $dateFrom, $dateTo);
                }
            }
        }

        return view('member.ph_plus')->with('user_details', $user_details)->with('ph_active', $ph_active)->with('ph_ended', $ph_ended)->with('total_ph_active', $total_ph_active)->with('total_ph_plus_active', $total_ph_plus_active)->with('requirement', $requirement)->with('total_ph_needed', $total_ph_needed);
    }

    public function history()
    {
        return view('member.ph_plus_history');
    }
}