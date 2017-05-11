<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Chat;
use Auth;
use App\Classes\NetworkClass;

class ChatController extends Controller
{

    public function check_friend()
    {
        return 'yes';
    }

    public function user_chat_history()
    {
        $id = Auth::user()->id;
        $user_id = $_POST['user_id'];
        $page = $_POST['cur_page'];
        $date = $_POST['date'];

        $url = 'http://chat.bitregion.com/request.php?data=chat_history&id='.$id.'&to_id='.$user_id."&page=".$page."&date=".$date;
        $content = file_get_contents($url);
        $members = json_decode($content, true);

        return view('ajax.user_chat')->with('chats',$members);
    }

    public function user_chat_history_more()
    {
        return "lalala";
    }

    public function user_info()
    {
        $id = $_POST['user_id'];

        $user = User::find($id);

        $username = $user->alias;
        $picture = $user->profile_pic;
        $hierarchy = $user->hierarchy;
        $global_level = $user->global_level;
        $hierarchy_bank = $user->hierarchy_bank;
        $global_level_bank = $user->global_level_bank;
        $upline_user_id = $user->upline_user_id;
        $referral_user_id = $user->referral_user_id;

        $result = json_encode(array('username'=>$username, 'picture'=>$picture,
            'hierarchy'=>$hierarchy, 'global_level'=>$global_level,
            'hierarchy_bank'=>$hierarchy_bank, 'global_level_bank'=>$global_level_bank,
            'upline_user_id'=>$upline_user_id, 'referral_user_id'=>$referral_user_id));

        return $result;
    }

    public function user_online()
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

        return view('ajax.online_user')->with('online_user',$result);
    }

}
