<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\ReferralClass;
use DB;
use Carbon\Carbon;
use Redirect;
use Auth;

class WebsiteViewController extends Controller
{
    public function index($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->alias;
        } else {
            $referral = ReferralClass::setReferral($referral)->alias;
        }

        if(!Auth::check()) {
            if (isset($_COOKIE['last_login'])) {
                $last_login = $_COOKIE['last_login'];
                $min_diff = Carbon::createFromFormat('Y-m-d H:i:s', $last_login)->diffInMinutes();

                if ($min_diff >= 5) {
                    setcookie("last_login", Carbon::now(), 2147483647, "/");
                    $_COOKIE['last_login'] = Carbon::now();

                    return Redirect::route('login');
                }
            }
        }

        if (!empty($position)) {
            $position = strtoupper($position);
            if ($position != "L" && $position != "R" && $position != "LEFT" && $position != "RIGHT")
            {
                $position = "";
            }
            if ($position == "LEFT")
            {
                $position = "L";
            }
            elseif($position == "RIGHT")
            {
                $position = "R";
            }
        }

        $totaluser = User::count();
        $totalcountries = count(User::select('country_code')->distinct()->get());
        $totalleader = User::where('leader_at','!=','0000-00-00 00:00:00')->count();

        return view('website.home')->with('referral', $referral)->with('position', $position)
            ->with('totaluser', $totaluser)->with('totalleader', $totalleader)->with('totalcountries', $totalcountries);
    }

    public function contact_us($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->alias;
        } else {
            $referral = ReferralClass::setReferral($referral)->alias;
        }

        if (!empty($position)) {
            $position = strtoupper($position);
            if ($position != "L" && $position != "R" && $position != "LEFT" && $position != "RIGHT")
            {
                $position = "";
            }
            if ($position == "LEFT")
            {
                $position = "L";
            }
            elseif($position == "RIGHT")
            {
                $position = "R";
            }
        }

        return view('website.contact_us')->with('referral', $referral)->with('position', $position);
    }

    public function infographic()
    {
        return view('website.infographic');
    }

    public function bitcoin_wallet()
    {
        return view('website.bitcoin_wallet');
    }

    public function buy_sell_bitcoin()
    {
        return view('website.buy_sell_bitcoin');
    }

    public function marketing_plan()
    {
        return view('marketing-plan.index');
    }
    public function leader_request()
    {
    	return view('website.leadership_req_form');
    }
    public function  valid_facebook_url($field){
	    if(!preg_match('/^(http\:\/\/|https\:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)/', $field)){
	        return 'False';
	    }
	    return 'True';
	}
    
}
