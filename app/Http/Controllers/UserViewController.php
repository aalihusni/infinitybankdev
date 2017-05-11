<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\User;
use Redirect;
use Crypt;
use App\Classes\ReferralClass;
use Input;

class UserViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function login()
    {
        return view('front.login');
    }

    public function login_2fa()
    {
        $cryptid = Input::get('data');
        if (empty($cryptid)) {
            return Redirect::to('login');
        } else {
            return view('front.security')->with('cryptid', $cryptid);
        }
    }

    public function signup($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->alias;
        } else {
            $referral = ReferralClass::setReferral($referral)->alias;
        }

        if (!empty($position)) {
            $position = strtoupper($position);
            if ($position != "L" && $position != "R" && $position != "LEFT" && $position != "RIGHT")
            {
                $position = "";
            }
            if ($position == "LEFT")
            {
                $position = "L";
            }
            elseif($position == "RIGHT")
            {
                $position = "R";
            }
        }

        return view('front.signup')->with('referral', $referral)->with('position', $position);
    }

    public function verify_email()
    {

        $email_enc = $_GET['data'];
        $email = Crypt::decrypt($email_enc);

        $user = User::where('email','=', $email)->first();
        $user_status = $user->email_verify_status;
        if($user_status > 0)
        {
            return view('front.login');
        }
        else
        {
            return view('front.verify')->with('email',$email);
        }
    }

    public function forgot_password()
    {
        return view('front.forgot_password');
    }

    public function password_reset()
    {
        $email_enc = $_GET['data'];

        $email = Crypt::decrypt($email_enc);
        $user = User::where('email','=', $email)->first();

        if(!$user)
        {
            return 'Password reset code is not valid';
        }
        else
        {
            return view('front.password_reset')->with('email_enc',$email_enc);
        }
    }
}