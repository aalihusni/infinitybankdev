<?php
namespace App\Classes;

use App\User;

class ReferralClass
{
    public static $refid = 2;
    public static $refalias = "user";

    public static function setReferral($alias = "", $position = "")
    {
        $refid = rand(2,100);
        $user = "";
        if (!empty($alias)) {
            $user = User::where('alias', '=', $alias)->first();

            if (!empty($user)) {
                if (count($user)) {
                    if ($user->id >= 2 && $user->id < 100 || $user->user_type == 3) {
                        $user = User::find($refid);
                        $alias = $user->alias;
                    }

                    setcookie("cookieRefID", $user->id, 2147483647, "/");
                    setcookie("cookieRefAlias", $alias, 2147483647, "/");
                    setcookie("cookieRefPosition", $position, 2147483647, "/");
                    $_COOKIE['cookieRefID'] = $user->id;
                    $_COOKIE['cookieRefAlias'] = $alias;
                    $_COOKIE['cookieRefPosition'] = $position;
                    return $user;
                }
            }
        }

        $user = User::find($refid);
        $alias = $user->alias;
        setcookie("cookieRefID", $refid, 2147483647, "/");
        setcookie("cookieRefAlias", $alias, 2147483647, "/");
        setcookie("cookieRefPosition", $position, 2147483647, "/");
        $_COOKIE['cookieRefID'] = $refid;
        $_COOKIE['cookieRefAlias'] = $alias;
        $_COOKIE['cookieRefPosition'] = $position;
        return $user;
    }

    public static function getReferral($alias = "")
    {
        if (isset($_COOKIE['cookieRefID'])) {
            $user = User::find($_COOKIE['cookieRefID']);
            return $user;
        } else {
            return self::setReferral($alias);
        }
    }

    public static function getPosition()
    {
        if (isset($_COOKIE['cookieRefPosition'])) {
            $position = $_COOKIE['cookieRefPosition'];
            return $position;
        }

        return "";
    }
}