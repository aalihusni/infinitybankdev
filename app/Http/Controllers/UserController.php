<?php

namespace App\Http\Controllers;

use App\Classes\UserClass;
use App\Classes\EmailClass;
use App\Classes\TrailLogClass;
use App\Classes\ReferralClass;
use App\Classes\CheckEmailClass;
use Auth;
use Input;
use Validator;
use Redirect;
use Hash;
use AppHelper;
use App\User;
use Socialite;
use Mail;
use Crypt;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use Cookie;

class UserController extends Controller
{
    public function login_2fa()
    {
        $cryptid = Input::get('cryptid');
        $secret = Input::get('secret');
        try {
            $user_id = Crypt::decrypt($cryptid);
        } catch (DecryptException $e) {
            return Redirect::to('login');
        }

        $user = User::find($user_id);

        if ($user->google2fa == 1) {

            $google2fa = new Google2FA();

            $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

            if ($valid) {
                Auth::loginUsingId($user_id);
                $user = Auth::user();

                //Check User Type
                if($user->user_type == '1')
                {
                    $logtitle = "Login";
                    $logfrom = "";
                    $logto = $user->alias;
                    TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);
                    setcookie("cookieFile", Crypt::encrypt('true'), 2147483647, "/");

                    return Redirect::to('admin/home');
                }
                else
                {
                    $logtitle = "Login";
                    $logfrom = "";
                    $logto = $user->alias;
                    TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

                    if ($user->country_code == "CN") {
                        setcookie("last_login", Carbon::now(), 2147483647, "/");
                        $_COOKIE['last_login'] = Carbon::now();
                    }

                    return Redirect::to('members/home');
                }
            } else {
                return Redirect::back()->withErrors("Invalid Authentication Code !");
            }
        } else {
            return Redirect::to('login');
        }

    }

    public function login()
    {
        //Validate Start
       
		
        $ip_country_code = "";
        if (isset($_COOKIE['country_code'])) {
        	//If already save
        	$ip_country_code = $_COOKIE['country_code'];
        }
        
        if ($ip_country_code == "CN")
        {
            $rules = array(
                'email' => 'email|required',
                'password' => 'required',

            );
        } else {
            $rules = array(
                'email' => 'email|required',
                'password' => 'required',
                'g-recaptcha-response' => 'required|captcha'

            );
        }

        $messages = [
            'g-recaptcha-response.required' => 'Please tick the check box next to "I\'m not a robot" to validate you\'re human',
            'g-recaptcha-response.recaptcha' => 'Robot detected',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);
        //Validation End

        //Declare Input Variables
        $email = Input::get('email');
        $password = Input::get('password');
        $rememberme = Input::get('rememberme');

        if ($validator->fails()) {

            return Redirect::to('login')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        } else {

            //Handle Remember Me Features
            if($rememberme=='1')
            { $remember = 'true'; } else { $remember = 'false';}

            $user = User::where('email','=',$email)->first();
            if(count($user))
            {
                if($user->email_verify_status < 1)
                {
                    $email_enc = Crypt::encrypt($email);
                    return Redirect::to('verify-email?data='.$email_enc);
                }

                if($user->google2fa == 1)
                {
                    if(Hash::check($password, $user->password))
                    {
                        $cryptid = Crypt::encrypt($user->id);
                        return Redirect::to('login-2fa?data=' . $cryptid);
                    }

                    return Redirect::to('login')
                        ->withErrors(trans('auth.failed'))
                        ->withInput(Input::except('password'));
                }
            }
            else
            {
                return Redirect::to('login')
                    ->withErrors(trans('auth.failed'))
                    ->withInput(Input::except('password'));
            }

            //Handle Login Credentials
            if(Auth::attempt(array('email' => $email, 'password' => $password), $remember))
            {
                $user = Auth::user();

                //Check User Type
                if($user->user_type == '1')
                {
                    $logtitle = "Login";
                    $logfrom = "";
                    $logto = $user->alias;
                    TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);
                    setcookie("cookieFile", Crypt::encrypt('true'), 2147483647, "/");

                    return Redirect::to('admin/home');
                }
                else
                {
                    $logtitle = "Login";
                    $logfrom = "";
                    $logto = $user->alias;
                    TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

                    if ($user->country_code == "CN") {
                        setcookie("last_login", Carbon::now(), 2147483647, "/");
                        $_COOKIE['last_login'] = Carbon::now();
                    }

                    return Redirect::to('members/home');
                }
            }
            else
            {
                return Redirect::to('login')
                    ->withErrors(trans('auth.failed'))
                    ->withInput(Input::except('password'));
            }
        }
    }

    public function generate_email_verification()
    {
        $code = md5(substr(str_shuffle("abcdefghijk" . rand(111111, 999999) . "lmnopqrstuvwxyz"), 0, 15));
        $user = User::where('email_verify_code', '=', $code)->first();
        if (count($user) > 0)
        {
            return self::generate_email_verification($type);
        } else {
            return $code;
        }
    }

    public function signup()
    {
        //Validate Start
        $ip_country_code = "";
        if (isset($_COOKIE['country_code'])) {
            //If already save
            $ip_country_code = $_COOKIE['country_code'];
        }

        if ($ip_country_code == "CN")
        {
            $rules = array(
                'email' => array('email', 'required', 'unique:users', 'regex:/^[^+]+$/'),
                'password' => 'required',
                'repassword' => 'required|same:password',
                'alias' => 'required_if:referrer,manual',

            );
        } else {
            $rules = array(
                'email' => array('email', 'required', 'unique:users', 'regex:/^[^+]+$/'),
                'password' => 'required',
                'repassword' => 'required|same:password',
                'alias' => 'required_if:referrer,manual',
                'g-recaptcha-response' => 'required|captcha'

            );
        }

        $messages = [
            'g-recaptcha-response.required' => 'Please tick the check box next to "I\'m not a robot" to validate you\'re human',
            'g-recaptcha-response.recaptcha' => 'Robot detected',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages );
        //Validation End

        //Declare Input Variables
        $email = Input::get('email');
        $password = Input::get('password');
        $referrer = Input::get('referrer');
        $alias = Input::get('alias');

        if ($validator->fails()) {

            return Redirect::to('signup')
                ->withErrors($validator)
                ->withInput(Input::except('password', 'repassword'));

        } else {
            /*
            $checkemail = CheckEmailClass::verifyEmail($email);
            if ($checkemail == "invalid") {
                return Redirect::to('signup')
                    ->withErrors("Email does not exist, please check if there is a typing error in the email and try again.")
                    ->withInput(Input::except('password', 'repassword'));
            }
            */
            if ($referrer == "manual")
            {
                $check_upline = User::where('alias', '=', $alias)->count();
                if ($check_upline) {
                    ReferralClass::setReferral($alias)->alias;
                } else {
                    return Redirect::back()
                        ->withErrors("Invalid Referrer Username. Please check with your Referrer for the correct Username Or select Default if you do not have Referrer")
                        ->withInput(Input::except('password', 'repassword'));
                }
            }

            $sign_up = UserClass::signUp($email, $password);
            $user_id = $sign_up['user_id'];
            $email_enc = $sign_up['email_enc'];

            return Redirect::to('verify-email?data='.$email_enc);

        }
    }

    public function do_verify_email($code)
    {

        $user = User::where('email_verify_code','=', $code)->where('email_verify_status','=', '0')->first();
        if(!$user)
        {
            return "Verification Code Not Valid";
        }
        else
        {
            $logtitle = "Email Verified";
            $logfrom = "";
            $logto = "";
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);
            $user->email_verify_status = '1';
            $user->save();
            Auth::loginUsingId($user->id);
            return Redirect::to('members/home')->with('message', 'You have successfully verify your email.');
        }

    }

    public function resend_verify_email()
    {
        $email_enc = $_GET['data'];
        $email = Crypt::decrypt($email_enc);

        $user = User::where('email','=', $email)->first();
        $user_verify_code = $user->email_verify_code;

        $logtitle = "Resend Verify Email";
        $logfrom = "";
        $logto = $email;
        TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

        $data = array('email' => $email, 'verificationcode' => $user_verify_code);

        Mail::send('emails.signup', $data, function($message) use($email)
        {
            $message->to($email)->subject('Thank you for registering with BitRegion. Please confirm your email address.');
        });

        return view('front.verify')->with('email',$email)->with('success','Email successfully sent.');
    }

    public function password_reset_request()
    {
        $email = $_POST['email'];
        $user = User::where('email', '=', $email)->first();
        if (!empty($user)) {
            if (count($user)) {
                $user_id = $user->id;
                $data = Crypt::encrypt($email);

                $logtitle = "Reset Password";
                $logfrom = "";
                $logto = $email;
                TrailLogClass::addTrailLog($user_id, $logtitle, $logto, $logfrom);

                $data = array('email' => $email, 'data' => $data);

                Mail::send('emails.password_reset', $data, function ($message) use ($email) {
                    $message->to($email)->subject('You have requested a password reset on BitRegion.com');
                });

                return view('front.forgot_password')->with('success', 'Password reset instructions sent to your email.');;
            }
        }

        return Redirect::back()->withErrors('Invalid Email Address');
    }

    public function password_reset()
    {
        //Validate Start
        $rules = array(
            'password' => 'required',
            'repassword' => 'required|same:password',
            'code' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        //Declare Input Variables
        $password = Input::get('password');
        $code = Input::get('code');
        $email = Crypt::decrypt($code);
        $newpassword = Hash::make($password);

        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator);

        } else {
            $user = User::where('email','=', $email)->first();
            if(!$user)
            {
                return Redirect::back()
                    ->withErrors('Action is not permitted!');
            }
            else
            {
                $logtitle = "Password Is Reset";
                $logfrom = "";
                $logto = $email;
                TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

                $user->password = $newpassword;
                $user->save();
                return view('front.login')->with('success','Password has been updated. Please login with your new password.');
            }
        }
    }

    public function logout()
    {
        if (Auth::check())
        {
            $logtitle = "Logout";
            $logfrom = "";
            $logto = Auth::user()->alias;
            TrailLogClass::addTrailLog(Auth::user()->id, $logtitle, $logto, $logfrom);
            setcookie("cookieFile", "", 1, "/");

            Auth::logout();
            return Redirect::to('login')->with('message', 'You have logged out!');
        }
        else
        {
            return Redirect::to('login');
        }
    }

    public function check_alias($alias)
    {
        return UserClass::checkAlias($alias);
    }

    public function movePlacement($downline1 = "", $downline2 = "", $downline3 = "")
    {
        $upline = Auth::user()->id;
        $status = UserClass::movePlacement($upline, $downline1, $downline2, $downline3);
        dd($status);
        if ($status)
        {
            //return Redirect::back();
        } else {
            //return Redirect::back()->withErrors('Operation not allowed !');
        }
    }
}