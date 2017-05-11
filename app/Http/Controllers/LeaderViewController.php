<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class LeaderViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $leader = User::where('leader_at','!=','0000-00-00 00:00:00')->orderBy('country_code','ASC')->get();
        return view('member.leaders')->with('leaders',$leader);
    }

}
