<?php
namespace App\Classes;

use App\User;
use Auth;

class MemberClass
{
    public static function setCompleteProfile($user_id, $alias, $firstname, $lastname, $country_code, $wallet_address = "")
    {
        $user = User::find($user_id);
        $logtitle = "Update Complete Profile";
        $logfrom = $user->alias."|".$user->firstname."|".$user->lastname."|".$user->$country_code;
        $logto = $alias."|".$firstname."|".$lastname."|".$country_code;
        TrailLogClass::addTrailLog($user_id, $logtitle, $logto, $logfrom);

        $user->alias = $alias;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->country_code = $country_code;
        if (!empty($wallet_address)) $user->wallet_address = $wallet_address;
        $user->save();
    }

    public static function updateReferrer($user, $referral)
    {
        if ($user->user_type == 3)
        {
            if ($referral->user_type == 2)
            {
                $user_id = $user->id;
                $logtitle = "Update Referrer";
                $logfrom = $user->referral_user_id . "|" . User::find($user->referral_user_id)->alias;
                $logto = $referral->id . "|" . $referral->alias;
                TrailLogClass::addTrailLog($user_id, $logtitle, $logto, $logfrom);

                $user->referral_user_id = $referral->id;
                $user->hierarchy_bank = "#" . $user->id . "#|" . $referral->hierarchy_bank;
                $user->global_level_bank = ($referral->global_level_bank + 1);
                $user->save();

                return true;
            }
        }

        return false;
    }
}