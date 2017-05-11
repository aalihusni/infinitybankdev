<?php
namespace App\Classes;

use Request;

class IPClass
{
    public static function getip()
    {
        if (trim(Request::header('X-Forwarded-For')) == "")
        {
            $ip = Request::ip();
            if (strpos($ip, ',') !== false) {
                $ip = explode(",",$ip);
                $ip = $ip[0];
            }

            return $ip;
        } else {
            $ip = Request::header('X-Forwarded-For');
            if (strpos($ip, ',') !== false) {
                $ip = explode(",",$ip);
                $ip = $ip[0];
            }

            return $ip;
        }
    }

    public static function checkwhitelist($ip)
    {
        //Google
        //==================================================
        $owner = "google";

        $from = "64.233.160.0";
        $to = "64.233.191.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "66.102.0.0";
        $to = "66.102.15.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "66.249.64.0";
        $to = "66.249.95.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "72.14.192.0";
        $to = "72.14.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "74.125.0.0";
        $to = "74.125.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "209.85.128.0";
        $to = "209.85.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "216.239.32.0";
        $to = "216.239.63.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        //MSN/LIVE
        //==================================================
        $owner = "msn";

        $from = "64.4.0.0";
        $to = "64.4.63.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "65.52.0.0";
        $to = "65.55.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "131.253.21.0";
        $to = "131.253.47.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "157.54.0.0";
        $to = "157.60.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "207.46.0.0";
        $to = "207.46.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "207.68.128.0";
        $to = "207.68.207.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        //YAHOO
        //==================================================
        $owner = "yahoo";

        $from = "8.12.144.0";
        $to = "8.12.144.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "66.196.64.0";
        $to = "66.196.127.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "66.228.160.0";
        $to = "66.228.191.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "67.195.0.0";
        $to = "67.195.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "68.142.192.0";
        $to = "68.142.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "72.30.0.0";
        $to = "72.30.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "74.6.0.0";
        $to = "74.6.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "98.136.0.0";
        $to = "98.139.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "202.160.176.0";
        $to = "202.160.191.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "209.191.64.0";
        $to = "209.191.127.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        //FACEBOOK
        //==================================================
        $owner = "facebook";

        $from = "66.220.144.0";
        $to = "66.220.159.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "69.63.176.0";
        $to = "69.63.191.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "204.15.20.0";
        $to = "204.15.23.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        //BLOCK.IO
        //==================================================
        $owner = "blockio";

        $from = "45.56.79.5";
        $to = "45.56.79.5";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        //CLOUDFLARE
        //==================================================
        $owner = "cloudlfare";

        $from = "103.21.244.0";
        $to = "103.21.244.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "103.22.200.0";
        $to = "103.22.200.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "103.31.4.0";
        $to = "103.31.4.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "104.16.0.0";
        $to = "104.16.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "108.162.192.0";
        $to = "108.162.192.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "131.0.72.0";
        $to = "131.0.72.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "141.101.64.0";
        $to = "141.101.64.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "162.158.0.0";
        $to = "162.158.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "172.64.0.0";
        $to = "172.64.255.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "173.245.48.0";
        $to = "173.245.48.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "188.114.96.0";
        $to = "188.114.96.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "190.93.240.0";
        $to = "190.93.240.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "197.234.240.0";
        $to = "197.234.240.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "198.41.128.0";
        $to = "198.41.128.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        $from = "199.27.128.0";
        $to = "199.27.128.255";
        $checkip = IPClass::checkip($from, $to, $ip);
        if ($checkip) return $owner;

        return false;
    }

    public static function checkip($from, $to, $ip)
    {
        $from = explode(".", $from);
        $to = explode(".", $to);
        $ip = explode(".", $ip);
        $from = str_pad($from[0], 3, '0', STR_PAD_LEFT).str_pad($from[1], 3, '0', STR_PAD_LEFT).str_pad($from[2], 3, '0', STR_PAD_LEFT).str_pad($from[3], 3, '0', STR_PAD_LEFT);
        $to = str_pad($to[0], 3, '0', STR_PAD_LEFT).str_pad($to[1], 3, '0', STR_PAD_LEFT).str_pad($to[2], 3, '0', STR_PAD_LEFT).str_pad($to[3], 3, '0', STR_PAD_LEFT);
        $ip = str_pad($ip[0], 3, '0', STR_PAD_LEFT).str_pad($ip[1], 3, '0', STR_PAD_LEFT).str_pad($ip[2], 3, '0', STR_PAD_LEFT).str_pad($ip[3], 3, '0', STR_PAD_LEFT);

        if ($ip >= $from && $ip <= $to)
        {
            return true;
        } else {
            return false;
        }
    }
}