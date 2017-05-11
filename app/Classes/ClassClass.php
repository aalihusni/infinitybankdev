<?php
namespace App\Classes;

use App\User;
use App\UserClasses;

class ClassClass
{
    public static function getUserClass($user_class)
    {
        $user_class_name = UserClasses::where('class', '=', $user_class)
            ->first();

        $return = $user_class_name->name;

        return $return;
    }

    public static function getQualifiedUplineID($id)
    {
        $user = User::find($id);
        $user_class = $user->user_class;
        $user_next_class = $user_class + 1;

        $hierarchy = $user->hierarchy;
        $hierarchy = explode("|", $hierarchy);

        if (count($hierarchy) > $user_next_class) {
            for ($i = $user_next_class; $i < count($hierarchy); $i++) {
                // Validate if user_next_level >= qualified upline level
                if ($i > 8) {
                    //if skip more than 8 set upline to 5 level from top
                    return str_replace("#", "", $hierarchy[count($hierarchy) - 5]);
                } else {
                    $upline = User::find(str_replace("#", "", $hierarchy[$i]));

                    if ($user_next_level <= $upline->user_account_type) {
                        $upline_last_login = $upline->last_login;
                        return str_replace("#", "", $hierarchy[$i]);
                    }
                }
            }
        }
    }
}