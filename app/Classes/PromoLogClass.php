<?php
namespace App\Classes;

use App\PromoLog;
use App\Classes\IPClass;
use Request;

class PromoLogClass
{
    public static function addPromoLog($referrer)
    {
        $traillog = new PromoLog();
        $traillog->ref_id = $referrer;
        $traillog->ip = IPClass::getip();
        $traillog->url = Request::url();
        $traillog->save();

        return $traillog->id;
    }
}