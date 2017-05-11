<?php
namespace App\Classes;

use App\Classes\IPClass;
use Request;

class TimeAgoClass
{
    public static function xTimeAgo($oldTime) {

        $newTime = date('Y-m-d H:i:s');
        $timeCalc = strtotime($newTime) - strtotime($oldTime);
        if ($timeCalc > (60*60*24)) {$timeCalc = round($timeCalc/60/60/24) . " days ago";}
        else if ($timeCalc > (60*60)) {$timeCalc = round($timeCalc/60/60) . " hours ago";}
        else if ($timeCalc > 60) {$timeCalc = round($timeCalc/60) . " minutes ago";}
        else if ($timeCalc > 0) {$timeCalc .= " seconds ago";}
        if($timeCalc == 0)
        {
            return "Just now!";
        }
        else {
            return $timeCalc;
        }
    }
}