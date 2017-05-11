<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\NetworkClass;
use Auth;

class NetworkViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $user_id = Auth::user()->id;
        $members = NetworkClass::getMembers($user_id);
        $subscribers = NetworkClass::getSubscribers($user_id);

        return view('member.network')->with('members', $members)->with('subscribers', $subscribers);
    }

}
