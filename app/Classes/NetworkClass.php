<?php
namespace App\Classes;

use App\User;
use App\UserClasses;
use DB;
use Crypt;

class NetworkClass
{
    public static function getMembers($user_id)
    {
        $users = User::where('referral_user_id', '=', $user_id)
            ->where('user_type', '=', '2')
            ->get();

        if (!empty($users))
        {
            if (count($users))
            {
                $return = "";

                foreach ($users as $user)
                {
                    $return[] = self::getUserDetails($user);
                }

                return $return;
            }
        }

        return false;
    }

    public static function getSubscribers($user_id)
    {
        $users = User::where('referral_user_id', '=', $user_id)
            ->where('user_type', '=', '3')
            ->get();

        if (!empty($users))
        {
            if (count($users))
            {
                $return = "";

                foreach ($users as $user)
                {
                    $return[] = self::getUserDetails($user);
                }

                return $return;
            }
        }

        return false;
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
        $return['email'] = $user->email;
        $return['mobile'] = $user->mobile;
        $return['sos_wechat'] = $user->sos_wechat;
        $return['sos_qq'] = $user->sos_qq;
        $return['sos_whatsapp'] = $user->sos_whatsapp;
        $return['sos_line'] = $user->sos_line;
        $return['sos_viber'] = $user->sos_viber;
        $return['sos_skype'] = $user->sos_skype;
        $return['sos_bbm'] = $user->sos_bbm;
        $return['country_code'] = $user->country_code;
        $return['user_class'] = $user->user_class;
        $return['user_class_name'] = self::getClassName($user->user_class);
        $return['user_type'] = $user->user_type;
        $return['user_type_name'] = $user_type_name;
        $return['upline_user_id'] = $user->upline_user_id;
        $return['tree_position'] = $user->tree_position;
        $return['profile_pic'] = $user->profile_pic;
        $return['id_verify_status'] = $user->id_verify_status;
        $return['selfie_verify_status'] = $user->selfie_verify_status;

        return $return;
    }

    public static function getClassName($user_class)
    {
        $user_class = UserClasses::where('class', '=', $user_class)
            ->first();

        return $user_class->name;
    }
}