<?php
namespace App\Classes;

use App\User;
use Auth;
use App\Classes\NetworkClass;

class ChatClass
{
    public static function online_member_list()
    {

        $user_id = Auth::user()->id;
        $url = 'http://chat.bitregion.com/request.php?data=user_online&id='.$user_id;
        $content = file_get_contents($url);
        $members = json_decode($content, true);


        $result = "";
        if (!empty($members)) {
            if (count($members)) {
                foreach ($members as $member) {
                    $user = User::find($member);
                    $result[] = NetworkClass::getUserDetails($user);
                }
            }
        }

        return $result;
    }

    public static function offline_member_list()
    {
        $members = User::where('active','=','0')->get();
        return $members;
    }

    public static function unregistered_member_list()
    {
        $members = User::where('user_type','=','3')->get();
        return $members;
    }

}