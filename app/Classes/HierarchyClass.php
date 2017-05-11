<?php
namespace App\Classes;

use App\User;
use App\UserClasses;
use Auth;
use Crypt;

class HierarchyClass
{
    public static function getReferrers($user_id, $referrer)
    {
        //echo $user_id."|".$referrer."<br>";
        $user = User::find($user_id);

        $hierarchy_bank = $user->hierarchy_bank;
        $referrer_full = "#".$referrer."#";
        $referrer_len = strlen($referrer_full);
        $referrer_post = strpos($hierarchy_bank, $referrer_full);
        $referrer_select = ($referrer_post + $referrer_len);
        $hierarchy = substr($hierarchy_bank,0,$referrer_select);

        $hierarchy = str_replace("#", "", $hierarchy);
        $hierarchy = array_reverse(explode("|", $hierarchy));

        for ($i = 0; $i < count($hierarchy); $i++) {
            $user = User::find($hierarchy[$i]);
            $user_details = self::getUserDetails($user);
            $user_details['referrals_count'] = self::getReferralsCount($hierarchy[$i]);
            $return[] = $user_details;
        }

        //dd($return);

        return $return;
    }

    public static function getReferralsCount($user_id)
    {
        $users = User::where('referral_user_id', '=', $user_id)
            ->get();

        return count($users);
    }

    public static function getReferrals($user_id)
    {
        $users = User::where('referral_user_id', '=', $user_id)
            ->get();

        if (!empty($users)) {
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $user_datails = self::getUserDetails($user);
                    $user_datails['referrals'] = self::getReferralsCount($user->id);
                    $return[] = $user_datails;
                }

                return $return;
            }
        }

        $return = "";
        return $return;
    }

    public static function generateHierarchy($user_id)
    {
        $level = 1;
        $user = User::find($user_id);

        $hierarchy = self::getUserDetails($user);
        $hierarchy['downline'] = self::getDownline($user_id, ($level + 1));

        return $hierarchy;
    }

    public static function getDownline($user_id, $level)
    {
        $users = User::where('upline_user_id', '=', $user_id)
            ->orderBy('tree_position', 'ASC')
            ->get();

        if (!empty($users))
        {
            $return = [];

            foreach ($users as $user)
            {
                $userDetails = self::getUserDetails($user);
                $user_id = $userDetails['id'];

                if ($level <> 4) {
                    $userDetails['downline'] = self::getDownline($user_id, ($level + 1));
                }

                $return[$userDetails['tree_position']] = $userDetails;
            }

            return $return;
        }

        return [];
    }

    public static function getUserDetails($user)
    {
        if ($user->user_type == 3)
        {
            $user_type_name = "Subscribers";
        }
        elseif ($user->user_type == 2)
        {
            $user_type_name = "Members";
        } else {
            $user_type_name = "Admin";
        }

        $return['id'] = $user->id;
        $return['cryptid'] = Crypt::encrypt($user->id);
        $return['alias'] = $user->alias;
        $return['user_class'] = $user->user_class;
        $return['user_class_name'] = self::getClassName($user->user_class);
        $return['user_type'] = $user->user_type;
        $return['email'] = $user->email;
        $return['mobile'] = $user->mobile;
        $return['sos_wechat'] = $user->sos_wechat;
        $return['sos_qq'] = $user->sos_qq;
        $return['sos_whatsapp'] = $user->sos_whatsapp;
        $return['sos_line'] = $user->sos_line;
        $return['sos_viber'] = $user->sos_viber;
        $return['sos_skype'] = $user->sos_skype;
        $return['sos_bbm'] = $user->sos_bbm;
        $return['user_type_name'] = $user_type_name;
        $return['upline_user_id'] = $user->upline_user_id;
        $return['upline_alias'] = "";
        $return['upline_alias'] = self::getUserAliass($user->upline_user_id);
        $return['tree_position'] = $user->tree_position;
        switch ($user->tree_position)
        {
            case 1:
                $return['tree_position_name'] = "Left";
                break;
            case 2:
                $return['tree_position_name'] = "Middle";
                break;
            case 3:
                $return['tree_position_name'] = "Right";
                break;
            default:
                $return['tree_position_name'] = "";
        }
        $return['profile_pic'] = $user->profile_pic;
        $return['id_verify_status'] = $user->id_verify_status;
        $return['selfie_verify_status'] = $user->selfie_verify_status;
        if ($user->id_verify_status)
        {
            $return['id_verify_tooltip'] = "ID Verified";
        } else {
            $return['id_verify_tooltip'] = "ID Not Verified";
        }
        if ($user->selfie_verify_status)
        {
            $return['selfie_verify_tooltip'] = "Photo Verified";
        } else {
            $return['selfie_verify_tooltip'] = "Photo Not Verified";
        }

        return $return;
    }

    public static function getUserAliass($user_id)
    {
        $user = User::find($user_id);
        if (!empty($user)) {
            $alias = $user->alias;

            return $alias;
        } else {
            return "";
        }
    }

    public static function getClassName($user_class)
    {
        $user_class = UserClasses::where('class', '=', $user_class)
            ->first();

        return $user_class->name;
    }
}