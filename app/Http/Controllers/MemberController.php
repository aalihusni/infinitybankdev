<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Input;
use Image;
use Redirect;
use Validator;
use App\Classes\MemberClass;
use App\Classes\BitcoinWalletClass;
use App\Classes\UserClass;
use App\Classes\TrailLogClass;
use Hash;
use File;
use URL;
use PragmaRX\Google2FA\Google2FA;
use Storage;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('member', ['except' => 'complete_profile']);
    }

    public function referral_setting()
    {

        //Validate Start
        $rules = array(
            'alias'             => 'required|alpha_num|min:5|max:12|unique:users'
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $user_id = Auth::user()->id;
        $alias = Input::get('alias');
        $page = Input::get('page');

        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {


            UserClass::setAlias($user_id, $alias);

            if (empty($page)) {
                return Redirect::route('referral-setting');
            } else {
                return Redirect::route($page);
            }
        }

    }

    public function update_wallet()
    {
    	//return Redirect::back()->withErrors('Sorry, update wallet address temporarily unavailable.Please try again in a 30 minutes.');
        //Validate Start
        $rules = array(
            'wallet_address'             => 'required|unique:users'
        );

        $messages = array( 'wallet_address.unique' => 'The wallet address has already been used.' );
        $validator = Validator::make(Input::all(), $rules, $messages);
        //Validation End

        $user_id = Auth::user()->id;
        $wallet_address = trim(Input::get('wallet_address'));

        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            if (BitcoinWalletClass::validBitcoinAddress($wallet_address))
            {
                UserClass::setWalletAddress($user_id, $wallet_address);
                return Redirect::back()->with('message', 'Your Bitcoin Wallet has been updated.');
            } else {
                return Redirect::back()->withErrors('Invalid Bitcoin Wallet Address');
            }
        }
    }


    public function create_wallet()
    {
        /*
        $test = Crypt::encrypt("Kay Hebat");
        echo $test."<br>";
        echo Crypt::decrypt($test)."<br>";
        //return view('member.upgrade');
        */

        $user_id = 1;
        $label = "admin test ".$user_id;
        $email = "admin+test".$user_id."@bitregion.com";


        $response = BitcoinWalletClass::createWalletAddress($user_id, $label, $email);
        $bitcoin_wallet_id = $response['id'];
        $wallet_address = $response['wallet_address'];
        /*
        $bitcoin_wallet_id = 1;
        $address = "1ETiheYYnNfBWB6LG6zkuFpEiSM3iqdjnJ";
        */
        $payment_type = "AB";

        echo $bitcoin_wallet_id."<br>";
        echo $wallet_address."<br>";
        echo $payment_type."<br>";

        $response = BitcoinWalletClass::createReceivingAddress($user_id, $bitcoin_wallet_id, $wallet_address, $payment_type);
        $bitcoin_wallet_receiving_id = $response['id'];
        $receiving_address = $response['receiving_address'];

        echo $bitcoin_wallet_receiving_id."<br>";
        echo $receiving_address."<br>";

    }

    public function upload_profile_pic()
    {
        //Validate Start
        $rules = array(
            'image'             => 'image|required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $image = Input::file('image');

        if ($validator->fails()) {

            return Redirect::to('members/personal-info')
                ->withErrors($validator)
                ->withInput(Input::except('password'));

        } else {

            if (File::exists("profiles/" . Auth::user()->profile_pic) && Auth::user()->profile_pic != 'no_img.jpg') {
                File::delete("profiles/" . Auth::user()->profile_pic);
            }

            if (Storage::exists("profiles/" . Auth::user()->profile_pic) && Auth::user()->profile_pic != 'no_img.jpg') {
                Storage::delete("profiles/" . Auth::user()->profile_pic);
            }

            $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();

            $path = 'profiles/' . $filename;
            $full_path = public_path($path);


            //Image::make($image->getRealPath())->fit(150)->save($full_path);
            $image_resize = Image::make($image->getRealPath())->fit(150)->encode('data-url');
            $image_parts = explode(";base64,", $image_resize);
            $image_base64 = base64_decode($image_parts[1]);
            Storage::put($path, $image_base64);

            $user = Auth::user();

            $logtitle = "Profile Image Uploaded";
            $logfrom = "";
            $logto = $filename;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->profile_pic = $filename;
            $user->save();

            return Redirect::back()->with('message', trans('member.upload_profile_pic_success'))->withInput();;

        }
    }

    public function upload_video()
    {
        //Validate Start
        return Redirect::back()->with('success','Thankyou for your submission. We will review your video and may publish it on public.');
    }

    public function personal_info()
    {
        //Validate Start
        $rules = array(
            'firstname'             => 'required',
            'lastname'             => 'required',
            'country'             => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $gender = Input::get('gender');
        $address = Input::get('address');
        $city = Input::get('city');
        $zipcode = Input::get('zipcode');
        $state = Input::get('state');
        $country = Input::get('country');

        if ($validator->fails()) {

            return Redirect::to('members/personal-info')
                ->withErrors($validator)
                ->withInput();

        } else {

            $user = Auth::user();

            $logtitle = "Update Personal Info";
            $logfrom = $user->firstname."|".$user->lastname."|".$user->gender."|".$user->address."|".$user->city."|".$user->zipcode."|".$user->state."|".$user->country_code;
            $logto = $firstname."|".$lastname."|".$gender."|".$address."|".$city."|".$zipcode."|".$state."|".$country;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->gender = $gender;
            $user->address = $address;
            $user->city = $city;
            $user->zipcode = $zipcode;
            $user->state = $state;
            $user->country_code = $country;
            $user->save();

            return Redirect::to('members/personal-info')->with('message', trans('member.personal_information_updated'));

        }
    }

    public function update_mobile()
    {
        //Validate Start
        $rules = array(
            'mobile'             => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $mobile = Input::get('mobile');
        $share = Input::get('share');

        if ($validator->fails()) {

            return Redirect::to('members/communication-info')
                ->withErrors($validator)
                ->withInput();

        } else {

            if($share == null) { $share = '0'; }
            $user = Auth::user();

            $logtitle = "Update Mobile";
            $logfrom = $user->mobile."|".$user->mobile_share;
            $logto = $mobile."|".$share;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->mobile = $mobile;
            $user->mobile_share = $share;
            $user->save();

            return Redirect::to('members/communication-info')->with('message', trans('member.mobile_no_updated'));

        }
    }

    public function update_email()
    {
        //Validate Start
        $rules = array(
            'email'             => array('email','required','unique:users','regex:/^[^+]+$/'),
            'renewemail'             => 'email|required|same:email',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $newemail = Input::get('email');
        $renewemail = Input::get('renewemail');

        if ($validator->fails()) {

            return Redirect::to('members/communication-info')
                ->withErrors($validator)
                ->withInput();

        } else {

            $user = Auth::user();

            $logtitle = "Update Email";
            $logfrom = $user->email;
            $logto = $newemail;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->email = $newemail;
            $user->save();

            return Redirect::to('members/communication-info')->with('message', trans('member.email_updated'));

        }
    }

    public function change_password()
    {
        //Validate Start
        $rules = array(
            'newpassword'             => 'required',
            'renewpassword'             => 'required|same:newpassword',
            'password'              => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $newpassword = Hash::make(Input::get('newpassword'));
        $password = Input::get('password');

        if ($validator->fails()) {

            return Redirect::to('members/change-password')
                ->withErrors($validator)
                ->withInput();
        }
        elseif(!Hash::check($password, Auth::user()->password)) {

            return Redirect::to('members/change-password')
                ->withErrors(trans('member.wrong_current_password'))
                ->withInput();

        } else {

            $user = Auth::user();

            $logtitle = "Update Password";
            $logfrom = "";
            $logto = "";
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            $user->password = $newpassword;
            $user->save();

            return Redirect::to('members/change-password')->with('message', trans('member.password_changed'));

        }
    }

    public function security_google2fa()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $google2fa = new Google2FA();

        $secret = Input::get('secret');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if ($valid) {
            if ($user->google2fa == 0) {
                $user->google2fa = 1;
                $user->save();
                return Redirect::back()->with('message', 'Two-Factor Authentication Has Been Enabled.');
            } else {
                $user->google2fa = 0;
                $user->google2fa_secret = "";
                $user->save();
                return Redirect::back()->with('message', 'Two-Factor Authentication Has Been Disabled.');
            }
        } else {
            return Redirect::back()->withErrors("Invalid Authentication Code !");
        }
    }

    public function complete_profile()
    {
        //Validate Start
        $rules = array(
            'alias'             => 'required|alpha_num|min:5|max:12|unique:users',
            'firstname'             => 'required',
            'lastname'             => 'required',
            'country_code'              => 'required',
            'wallet_address'             => 'required|unique:users'
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $alias = Input::get('alias');
        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $country_code = Input::get('country_code');
        $wallet_address = Input::get('wallet_address');

        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $user_id = Auth::user()->id;

            if (BitcoinWalletClass::validBitcoinAddress($wallet_address))
            {
                UserClass::setWalletAddress($user_id, $wallet_address);
            } else {
                return Redirect::back()->withErrors('Invalid Bitcoin Wallet Address')->withInput();
            }

            MemberClass::setCompleteProfile($user_id, $alias, $firstname, $lastname, $country_code);

            return Redirect::to('members/home')->with('message', trans('member.welcome_to_bitregion'));

        }
    }

    public function social_media_info()
    {
        $sos_qq = Input::get('sos_qq');
        $sos_wechat = Input::get('sos_wechat');
        $sos_viber = Input::get('sos_viber');
        $sos_whatsapp = Input::get('sos_whatsapp');
        $sos_line = Input::get('sos_line');
        $sos_skype = Input::get('sos_skype');
        $sos_bbm = Input::get('sos_bbm');
        $share = Input::get('share');

        $user = Auth::user();
        $user->sos_qq = $sos_qq;
        $user->sos_wechat = $sos_wechat;
        $user->sos_viber = $sos_viber;
        $user->sos_whatsapp = $sos_whatsapp;
        $user->sos_line = $sos_line;
        $user->sos_skype = $sos_skype;
        $user->sos_bbm = $sos_bbm;
        $user->sos_share = $share;
        $user->save();

        return Redirect::to('members/social-media-info')->with('success', 'Social Media Information has been updated!');
    }

    public function update_referral($alias)
    {

        $user = Auth::user();

        if ($user->user_type == 3)
        {
            if ($user->upline_user_id == 0)
            {
                $referral = User::where('alias', '=', $alias)->first();
                if (!empty($referral))
                {
                    if (count($referral) > 0)
                    {
                        $status = MemberClass::updateReferrer($user, $referral);

                        if ($status)
                        {
                            return Redirect::back();
                        }
                    }
                }
                return Redirect::back()->withErrors('Invalid Referer !');
            }
            return Redirect::back()->withErrors('Your Upline Is Currently Locked. Please Try Again After 1 Hour !');
        }
        return Redirect::back()->withErrors('You No Longer Can Update Your Referrer !');
    }
}