<?php
namespace App\Http\Controllers;
use Mail;
use App\BitcoinBlockchainWallet;
use App\User;
use App\News;
use App\Classes\SharesClass;
use App\Classes\UserClass;
use App\Classes\PAGBClass;
use App\Classes\PHGHClass;
use Auth;
use Crypt;
use Config;
use Redirect;
use PragmaRX\Google2FA\Google2FA;
use Alert;
use Illuminate\Http\Request;
use App\Classes\MemberClass;

class MemberViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member', ['except' => ['complete_profile', 'blockchain_callback', 'blockio_callback', 'blockio_status', 'blockio_confirmations', 'generate_qr']]);
    }

    public function home()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $ref_id = $user->referral_user_id;

        $shares_balance = SharesClass::getSharesBalance($user_id);
        $shares_balance_type = SharesClass::getSharesBalanceTypeAll($user_id);

        $user_details = UserClass::getUserDetails($user_id);
        $upline_details = UserClass::getUserDetails($ref_id);
        $new_class_details = PAGBClass::getNewClassDetails($user_id);

        $total_active_dividen = PHGHClass::getTotalActiveDividen($user_id, "4", "<=");

        $charts = PAGBClass::getChartData($user_id);
        $total_pagb = PAGBClass::getTotalPAGB($user_id);

        $news = News::where('order','1')->first();

        return view('member.home')->with('shares_balance', $shares_balance)->with('shares_balance_type', $shares_balance_type)->with('user_details', $user_details)->with('new_class_details', $new_class_details)->with('total_active_dividen', $total_active_dividen)->with('charts', $charts)->with('total_pagb', $total_pagb)->with('news', $news)->with('upline_details', $upline_details);
    }
    public function homeAliasCheck(Request $request){
       $validate = UserClass::checkAlias($request->alias);
        $user = Auth::user();
       if ($validate == "KO"){

           if ($user->user_type == 3)
           {
               if ($user->upline_user_id == 0)
               {
                   $referral = User::where('alias', '=', $request->alias)->first();
                   if (!empty($referral))
                   {
                       if (count($referral) > 0)
                       {
                           $status = MemberClass::updateReferrer($user, $referral);

                           if ($status)
                           {
                               alert()->success('Success!');
                               return Redirect::back();
                           }
                       }
                   }
                   return Redirect::back()->withErrors('Invalid Referer !');
               }
               return Redirect::back()->withErrors('Your Upline Is Currently Locked. Please Try Again After 1 Hour !');
           }
           return Redirect::back()->withErrors('You No Longer Can Update Your Referrer !');


       }else{
           alert()->error('Invalid referrer user ', 'Error');
           return back();
       }
    }

    public function personal_info()
    {
        return view('member.personal_info');
    }

    public function communication_info()
    {
        $countrycode = Auth::user()->country_code;
        $json = file_get_contents('https://restcountries.eu/rest/v1/alpha?codes='.$countrycode);
        $obj = json_decode($json)[0];
        $dc = $obj->callingCodes[0];

        return view('member.communication_info')->with('dc',$dc);
    }

    public function change_password()
    {
        return view('member.change_password');
    }

    public function security_google2fa()
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $google2fa = new Google2FA();

        if ($user->google2fa == 0) {
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();
        }

        $google2fa_url = $google2fa->getQRCodeGoogleUrl(
            'BitRegion',
            $user->email,
            $user->google2fa_secret
        );

        return view('member.security')->with('google2fa', $user->google2fa)->with('google2fa_url', $google2fa_url);
    }

    public function referral_setting()
    {
        $user_id = Auth::user()->id;
        $alias = User::find($user_id)->alias;

        return view('member.referral_setting')->with('alias', $alias);
    }

    public function social_media_info()
    {
        return view('member.social_media_info');
    }

    public static function getCountryCode() {
        $json = file_get_contents('http://ip-api.com/json');
        $obj = json_decode($json);
        if($obj->countryCode != 'MY' || $obj->countryCode != 'ID')
        {
            return 'MY';
        }
        else
        {
            return $obj->countryCode;
        }
    }

    public function complete_profile()
    {
        if(!Auth::check())
        {
            return Redirect::to('login')->with('success', 'You are not the logged in!');
        }

        return view('member.complete_profile');
    }

    public function new_member()
    {
        return view('member.new_member');
    }

    public function bitcoin_wallet()
    {
        return view('member.bitcoin_wallet');
    }

    public function marketing_meterial()
    {
        return view('member.marketing_meterial');
    }

}