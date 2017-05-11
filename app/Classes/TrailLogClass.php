<?php
namespace App\Classes;

use App\TrailLog;
use App\Classes\IPClass;
use Request;

class TrailLogClass
{
    public static function addTrailLog($user_id, $title, $to, $from = "", $onbehalf_user_id = "")
    {
        $traillog = new TrailLog();
        $traillog->user_id = $user_id;
        if (!empty($onbehalf_user_id)) {
            $traillog->onbehalf_user_id = $onbehalf_user_id;
        }
        $traillog->title = $title;
        $traillog->from = $from;
        $traillog->to = $to;
        $traillog->ip = IPClass::getip();
        $traillog->url = Request::url();
        $traillog->save();
    }
}