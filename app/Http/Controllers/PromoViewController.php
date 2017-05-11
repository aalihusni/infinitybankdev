<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\User;
use Redirect;
use Crypt;
use App\Classes\ReferralClass;
use Input;
use App\PromoLog;
use App\PromoPages;
use App\PromoBanners;
use App\Classes\PromoLogClass;
use Illuminate\Support\Facades\Session;

class PromoViewController extends Controller
{

    public function explainer_video($alias = "", $position = "")
    {
        if (empty($alias))
        {
            $referral = ReferralClass::getReferral($alias)->id;
        } else {
            $referral = ReferralClass::setReferral($alias)->id;
        }

       // Session::put('vid-ref', $alias);

        if(isset($_GET['lang']))
        {
            Session::put('lang', $_GET['lang']);
            return Redirect::route('explainer-video',$alias);
        }
        else {

            $totaluser = User::count();
            $totalcountries = count(User::select('country_code')->distinct()->get());
            $totalleader = User::where('leader_at', '!=', '0000-00-00 00:00:00')->count();

            PromoLogClass::addPromoLog($referral);


            return view('promo.video01')->with('referral', $referral)->with('position', $position)
                ->with('totaluser', $totaluser)->with('totalleader', $totalleader)->with('totalcountries', $totalcountries);

        }
    }

    public function explainer_video_russia($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->id;
        } else {
            $referral = ReferralClass::setReferral($referral)->id;
        }

        $totaluser = User::count();
        $totalcountries = count(User::select('country_code')->distinct()->get());
        $totalleader = User::where('leader_at','!=','0000-00-00 00:00:00')->count();

        PromoLogClass::addPromoLog($referral);


        return view('promo.video01')->with('referral', $referral)->with('position', $position)
            ->with('totaluser', $totaluser)->with('totalleader', $totalleader)->with('totalcountries', $totalcountries);
    }

    public function marketing_plan($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->id;
        } else {
            $referral = ReferralClass::setReferral($referral)->id;
        }

        $totaluser = User::count();
        $totalcountries = count(User::select('country_code')->distinct()->get());
        $totalleader = User::where('leader_at','!=','0000-00-00 00:00:00')->count();

        PromoLogClass::addPromoLog($referral);


        return view('promo.video02')->with('referral', $referral)->with('position', $position)
            ->with('totaluser', $totaluser)->with('totalleader', $totalleader)->with('totalcountries', $totalcountries);
    }

    public function crowdfunding($referral = "", $position = "")
    {
        if (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->id;
        } else {
            $referral = ReferralClass::setReferral($referral)->id;
        }

        $totaluser = User::count();
        $totalcountries = count(User::select('country_code')->distinct()->get());
        $totalleader = User::where('leader_at','!=','0000-00-00 00:00:00')->count();

        PromoLogClass::addPromoLog($referral);


        return view('promo.video03')->with('referral', $referral)->with('position', $position)
            ->with('totaluser', $totaluser)->with('totalleader', $totalleader)->with('totalcountries', $totalcountries);
    }

    public function promo($alias = "", $referral = "", $position = "")
    {
        if (empty($alias))
        {
            echo "error!";
        }
        elseif (empty($referral))
        {
            $referral = ReferralClass::getReferral($referral)->id;
        } else {
            $referral = ReferralClass::setReferral($referral)->id;
        }

        $logid = PromoLogClass::addPromoLog($referral);

        $promobanners = PromoBanners::where('alias','=',$alias)->first();
        $promopages = PromoPages::find($promobanners->page_id);

        return view('promo.banners')->with('promobanners', $promobanners)->with('promopages', $promopages)
            ->with('referral', $referral)->with('position', $position)->with('logid', $logid);
    }

    public function redirect($alias = "", $id = "")
    {
        $promopages = PromoPages::where('alias','=',$alias)->first();
        $log = PromoLog::find($id);
        $log->status = '1';
        $log->save();

        return Redirect::to($alias);
    }
}