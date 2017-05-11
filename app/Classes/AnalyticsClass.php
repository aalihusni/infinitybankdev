<?php
namespace App\Classes;

use App\Analytics;
use App\Classes\IPClass;
use Crypt;
use Request;

class AnalyticsClass
{
    public static function addAnalytics($user_id)
    {
        $addLog = true;

        if (isset($_COOKIE['cookieFile'])) {
            $cookieadmin = Crypt::decrypt($_COOKIE['cookieFile']);
            if ($cookieadmin) {
                $addLog = false;
            }
        }

        if ($addLog == true) {
            $traillog = new Analytics();
            $traillog->user_id = $user_id;
            $traillog->ip = IPClass::getip();
            $traillog->url = Request::url();
            $traillog->save();
        }
    }
}