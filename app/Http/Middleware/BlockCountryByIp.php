<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\IPClass;
use Cookie;
use Session;
use Lang;
use GeoIP;
use Request;
use Redirect;

class BlockCountryByIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $uridomain = Request::server ("SERVER_NAME");
        $uripath = Request::url();

        $domain = str_replace("www.","", $uridomain);
        $path =  str_replace("https://www.","", $uripath);
        $path =  str_replace("http://www.","", $path);
        $path =  str_replace("https://","", $path);
        $path =  str_replace("http://","", $path);
        $path =  str_replace($domain."/","", $path);
        $path =  str_replace($domain,"", $path);

        $ip = IPClass::getip();
        if ($ip == "::1") $ip = "127.0.0.1";
        if ($ip <> "127.0.0.1") {
            $ip_country_code = GeoIP::getLocation($ip)['isoCode'];
        } else {
            $ip_country_code = "localhost";
        }

        if ($uridomain == "china.bitregion.com") {
            Session::put('lang', 'cn');
        }

        if ($uridomain <> "china.bitregion.com" && $ip_country_code == "CN")
        {
            //return Redirect::to('http://china.bitregion.com/'.$path);
        }

        if ($uridomain == "china.bitregion.com" && $ip_country_code <> "CN")
        {
            return Redirect::to('http://www.bitregion.com/'.$path);
        }

        if ($domain <> "bitregion.com")
        {
            $whitelist = IPClass::checkwhitelist($ip);
            if (!$whitelist) {
                if ($ip_country_code <> "MY" && $ip_country_code <> "CN" && $ip_country_code <> "localhost") {
                    //http_response_code(404);
                    //dd();
                }
            }
        }

        if (isset($_COOKIE['country_code'])) {
            //If already save
            $ip_country_code = $_COOKIE['country_code'];
        } else {
            //if not save
            $ip = IPClass::getip();
            //if on localhost set localhost ip
            if ($ip == "::1") $ip = "127.0.0.1";
            //check if white list ip (google/msn/yahoo/facebook)
            $whitelist = IPClass::checkwhitelist($ip);
            if (!$whitelist) {
                //if not white list ip (google/msn/yahoo/facebook)
                /*
                $url = "https://freegeoip.net/json/" . $ip;

                $client = new \GuzzleHttp\Client();
                $response = $client->request('GET', $url, [
                ]);

                $status_code = $response->getStatusCode();
                if ($status_code == 200) {
                    $data = $response->getBody()->getContents();
                    $ip = json_decode($data);
                    $ip_country_code = trim($ip->country_code);
                    if (empty($ip_country_code)) $ip_country_code = "EMPTY";
                } else {
                    $ip_country_code = "ERROR";
                }
                */
                if ($ip == "127.0.0.1")
                {
                    $ip_country_code = "Local";
                } else {
                    $ip_country_code = GeoIP::getLocation($ip)['isoCode'];
                }
            } else {
                //if white list ip (google/msn/yahoo/facebook)
                $ip_country_code = $whitelist;
            }

            setcookie("country_code", $ip_country_code, strtotime('+1 month'), "/");
        }

        if ($ip_country_code == "US") {
            return $next($request);
            //http_response_code(404);
            //dd();
        } elseif ($ip_country_code == "CN" || $ip_country_code == "HK" || $ip_country_code == "TW") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to China
                setcookie("cookieRefID", 3804, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 3804;
            }

            //Set default language to china if first visit
            if (!isset($_COOKIE['lang']))
            {
                Session::put('lang', 'cn');
            }
            setcookie("lang", "set", strtotime('+15 minute'), "/");
            $_COOKIE['lang'] = 'set';

            return $next($request);
        } elseif ($ip_country_code == "IN") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to India
                setcookie("cookieRefID", 3918, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 3918;
            }

            return $next($request);
        } elseif ($ip_country_code == "VN") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to Vietnam
                setcookie("cookieRefID", 3322, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 3322;
            }

            return $next($request);
        } elseif ($ip_country_code == "PH") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to Philippines
                setcookie("cookieRefID", 3926, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 3926;
            }

            return $next($request);
        } elseif ($ip_country_code == "JP") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to Japan
                setcookie("cookieRefID", 4245, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 4245;
            }

            return $next($request);
        } elseif ($ip_country_code == "KH") {
            if (!isset($_COOKIE['cookieRefID'])) {
                //Set referral to Cambodia
                setcookie("cookieRefID", 6265, 2147483647, "/");
                $_COOKIE['cookieRefID'] = 6265;
            }

            return $next($request);
        } else {
            return $next($request);

        }
    }
}
