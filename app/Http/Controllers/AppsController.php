<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Input;
use App\User;
use Response;
use Crypt;
use Redirect;

class AppsController extends Controller
{

    public function storeDeviceID() {

        $uname = $_GET['uname'];
        $pwd = $_GET['pwd'];
        $deviceid = $_GET['deviceid'];
        $platformid = $_GET['platformid'];

        if (Auth::attempt(['email' => $uname, 'password' => $pwd])) {
            $user_select = User::select('id')->where('email', '=', $uname)->get();

            foreach($user_select as $usr_select) {
                $user = User::find($usr_select->id);
                $user->device_id = $deviceid;
                $user->save();
            }

            $exec_curl =  $this->PushToDevice($deviceid, $platformid, "Authentication success");

            $user_id = Auth::user()->id;

            $data = Crypt::encrypt($user_id);

            return Response::json(array(
                'validation_failed' => 0,
                'return_value' => $data
            ));

        }
        else {
            return Response::json(array(
                'validation_failed' => 1,
                'return_value' => "Authentication failed"
            ));
        }
    }

    public function device_login($id) {

        $data = Crypt::decrypt($id);
        Auth::loginUsingId($data);

        return Redirect::to('members/home');
    }

    public function PushToDevice($device_id, $platform_id, $msg) {
        $response = $this->sendRequest('POST', 'https://api.pushbots.com', '/push/all', $device_id, $platform_id, $msg);
        return $response;
    }

    public function sendRequest($method, $url, $path, $device_id, $platform_id, $msg)
    {
        $appId = "565e62e5177959d70d8b4567";
        $appSecret = "4954c6a1bddc2fb58e45f0443951c604";
        $device_id = $device_id;
        //$push;
        $timeout = 0;
        $connectTimeout = 0;
        $sslVerifypeer = 0;


        $data = array("platform" => $platform_id, "token" => $device_id, "msg" => $msg, "sound" => "ping.aiff");
        $data_string = json_encode($data);

        $ch = curl_init($url . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'x-pushbots-appid: ' . $appId,
                'x-pushbots-secret: ' . $appSecret,
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        return $result;
    }
}


