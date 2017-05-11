<?php

namespace App\Http\Controllers;

use App\User;
use App\Classes\UserClass;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\PAGBClass;
use Redirect;

class PAGBViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $user_details = UserClass::getUserDetails($user_id);
        $new_class_details = PAGBClass::getNewClassDetails($user_id);
        $matrix = PAGBClass::getMatrix($user_id);
        $waiting_confirmations = PAGBClass::getWaitingConfirmations($user_id);
        return view('member.assistant')->with('user_details', $user_details)->with('new_class_details', $new_class_details)->with('waiting_confirmations', $waiting_confirmations)->with('matrix', $matrix);

    }

    public function upgrade($upline = "", $position = "")
    {
        $user = Auth::user();
        $user_id = $user->id;
        $user_class = $user->user_class;
        $user_wallet_address = $user->wallet_address;
        $locked_upline_user_id = $user->locked_upline_user_id;
        $locked_upline_at = $user->locked_upline_at;

        if (empty(trim($user_wallet_address))) return redirect()->route('bitcoin-wallet')->withErrors('Please update your bitcoin wallet address');

        if ($user_class < 8) {
            if ($locked_upline_user_id) {
                //Get time elapse
                $time_now = Carbon::now();
                $time_lock = Carbon::createFromFormat('Y-m-d H:i:s', $locked_upline_at);
                $diff_min = $time_now->diffInMinutes($time_lock);
                $diff_sec = $time_now->diffInSeconds($time_lock);

                //Get time left
                $diff_min_sec = $diff_sec - ($diff_min * 60);
                $min_left = 60 - ceil(($diff_sec / 60));
                $sec_left = ((60 * 60) - $diff_sec) - ($min_left * 60);
                $time_left['min'] = $min_left;
                $time_left['sec'] = $sec_left;

                if ($diff_min >= 65) {
                    $waiting_confirmations = PAGBClass::getWaitingConfirmations($user_id);
                    if (!$waiting_confirmations) {
                        PAGBClass::setUnlockedQualifiedUplineUserID($user_id);
                    }
                }
            }

            if ($user->upline_user_id == 0) {
                if (!empty($upline)) {
                    //Manual Placement
                    $onbehalf_user_id = "";
                    $empty_slot = PAGBClass::getEmptyTreeSlot($upline, $user->referral_user_id);
                    if (!empty($empty_slot)) {
                        $upline = User::where('alias', '=', $upline)->first();
                        $upline_user_id = $upline->id;
                        $upline_hierarchy = $upline->hierarchy;
                        $upline_global_level = $upline->global_level;

                        if (!empty($position)) {
                            if ($empty_slot['position']['slot' . $position] == 0) {
                                $empty_tree_position = $position;

                                $locked_status = PAGBClass::setLockedQualifiedUplineUserID($user_id, $upline_user_id, $upline_hierarchy, $upline_global_level, $empty_tree_position, $onbehalf_user_id);
                                if (isset($locked_status['error'])) return Redirect::back()->withErrors($locked_status['error']);
                            } else {
                                return Redirect::back()->withErrors('Position taken');
                            }
                        } else {
                            return Redirect::back()->withErrors('Position not selected');
                        }
                    } else {
                        return Redirect::back()->withErrors('Position full');
                    }
                }
            }

            $upgrade_details = PAGBClass::getClassUpgradeDetails($user_id);

            //Get time elapse
            $user = Auth::user();
            $locked_upline_at = $user->locked_upline_at;
            $time_now = Carbon::now();
            $time_lock = Carbon::createFromFormat('Y-m-d H:i:s', $locked_upline_at);
            $diff_min = $time_now->diffInMinutes($time_lock);
            $diff_sec = $time_now->diffInSeconds($time_lock);

            //Get time left
            if ($diff_sec < 5) {
                $time_left['min'] = 59;
                $time_left['sec'] = 59;
            } else {
                $diff_min_sec = $diff_sec - ($diff_min * 60);
                $min_left = 60 - ceil(($diff_sec / 60));
                $sec_left = ((60 * 60) - $diff_sec) - ($min_left * 60);
                if ($min_left == 60 || $min_left < 0) $min_left = 59;
                if ($sec_left == 60 || $sec_left < 0) $sec_left = 59;
                $time_left['min'] = $min_left;
                $time_left['sec'] = $sec_left;
            }

            if (isset($upgrade_details['error'])) return  Redirect::route('passport')->withErrors($upgrade_details['error']);
            //if (!$upgrade_details) return redirect()->route('passport');

            return view('member.upgrade')->with('upgrade_details', $upgrade_details)->with('time_left', $time_left);
        } else {
            return redirect()->route('assistant')->withErrors('You have reach highest user class');
        }
    }

    public function history()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $histories = PAGBClass::getPAGBHistory($user_id);

        return view('member.pagb_history')->with('histories', $histories);
    }
}
