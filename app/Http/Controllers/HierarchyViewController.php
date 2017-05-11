<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\HierarchyClass;
use Response;

class HierarchyViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }


    public function network()
    {
        $user_id = Input::get('id');
        if (!isset($user_id)) {
            $user = Auth::user();
            $user_id = $user->id;

            $top = $user_id;
            $pageup = $user_id;
            $level = 1;
        } else {
            $user = Auth::user();
            $upline = $user->id;
            $global_level = $user->global_level;
            $downline = User::find($user_id);
            $global_level_dl = $downline->global_level;

            $top = $upline;
            $pageup = $downline->upline_user_id;
            $level = ($global_level_dl - $global_level) + 1;

            if ($global_level > $global_level_dl)
            {
                return Response::view('errors.500', array(), 404);
            }
        }

        $navigation['top'] = $top;
        $navigation['pageup'] = $pageup;
        $navigation['level'] = $level;
        $hierarchy = HierarchyClass::generateHierarchy($user_id);
        $empty['alias'] = "";
        $empty['id'] = 0;
        $empty['user_class'] = 0;
        $empty['user_class_name'] = "";
        $empty['profile_pic'] = "empty.png";
        $empty['id_verify_status'] = 0;
        $empty['selfie_verify_status'] = 0;
        $empty['id_verify_tooltip'] = "";
        $empty['selfie_verify_tooltip'] = "";

        return view('member.network_hierarchy')->with('navigation',$navigation)->with('hierarchy',$hierarchy)->with('empty',$empty);
    }

    public function referral()
    {
        $user_id = Input::get('id');
        if (!isset($user_id)) {
            $user_id = Auth::user()->id;
        } else {
            $user = Auth::user();
            $upline = $user->id;
            $global_level = $user->global_level_bank;
            $downline = User::find($user_id);
            $global_level_dl = $downline->global_level_bank;

            $top = $upline;
            $pageup = $downline->upline_user_id;
            $level = ($global_level_dl - $global_level) + 1;

            if ($global_level > $global_level_dl)
            {
                return Response::view('errors.500', array(), 404);
            }
        }
        $referrers = HierarchyClass::getReferrers($user_id, Auth::user()->id);
        $referrals = HierarchyClass::getReferrals($user_id);

        return view('member.referral')->with('referrers', $referrers)->with('referrals', $referrals);
    }

    public function network_new()
    {
        return view('member.network_hierarchy_new');
    }
}
