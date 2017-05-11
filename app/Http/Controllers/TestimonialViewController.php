<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Testimonials;

class TestimonialViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $testi = Testimonials::where('user_id','=',Auth::user()->id)->count();
        if($testi < 1)
        {
            $data = 0;
            $testim = 'na';
        } else {
            $data = 1;
            $testim = Testimonials::where('user_id','=',Auth::user()->id)->first();
        }
        return view('member.testi')->with('data',$data)->with('testi',$testim);
    }

    public function submission()
    {
        $testis = Testimonials::where('status','>','0')->get();
        $objectData = array();
        foreach($testis as $testi)
        {
            $user = User::find($testi->user_id);

            $objectData[] = (object)array(
                'id'=>$testi->id,
                'user_id'=>$user->id,
                'user_img'=>$user->profile_pic,
                'user_name'=>$user->firstname.' '.$user->lastname,
                'user_alias'=>$user->alias,
                'website'=>$testi->website,
                'url'=>$testi->url,
                'status'=>$testi->status,
                'updated_at'=>$testi->updated_at
            );
        }
        return view('admin.testi')->with('objectData',$objectData);
    }
}
