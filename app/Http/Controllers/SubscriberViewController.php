<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\PromoLog;
use App\PromoPages;
use App\PromoBanners;
use App\PromoSubscribers;
use Redirect;
use Crypt;
use Auth;
use DB;
use App\Classes\ReferralClass;
use Input;
use App\Classes\TimeAgoClass;

class SubscriberViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function pages()
    {
        $promopages = PromoPages::get();

        foreach($promopages as $promopage)
        {
            if(Auth::user()->id < 3282) {
                $promocount = PromoLog::where('url', 'LIKE', '%/' . $promopage->alias . '/%')
                    ->where('ref_id', '<', 3282)
                    ->count();
                $optincount = PromoSubscribers::where('ref_id', '<', 3282)
                    ->where('page_id', '=', $promopage->id)
                    ->count();
                $closecount = PromoSubscribers::where('ref_id', '<', 3282)
                    ->where('page_id', '=', $promopage->id)
                    ->where('closed', '>', 0)
                    ->count();
            } else {
                $promocount = PromoLog::where('url', 'LIKE', '%/' . $promopage->alias . '/%')
                    ->where('ref_id', '=', Auth::user()->id)
                    ->count();
                $optincount = PromoSubscribers::where('ref_id', '=', Auth::user()->id)
                    ->where('page_id', '=', $promopage->id)
                    ->count();
                $closecount = PromoSubscribers::where('ref_id', '=', Auth::user()->id)
                    ->where('page_id', '=', $promopage->id)
                    ->where('closed', '>', 0)
                    ->count();
            }

            $lang_array = explode(",", $promopage->lang);

            $PagesData[] = (object)array('id'=>$promopage->id,'alias'=>$promopage->alias,'title'=>$promopage->title,
                'description'=>$promopage->description,'image'=>$promopage->image,'lang'=>$lang_array,'totalView'=>$promocount,
                'OptinCount'=>$optincount,'CloseCount'=>$closecount
            );
        }
        $promopages = $PagesData;
        return view('member.promo_pages')->with('promopages',$promopages);
    }

    public function banner()
    {

        $promobanners = PromoBanners::select('promo_banners.*', 'promo_pages.title')
            ->leftJoin('promo_pages','promo_banners.page_id','=','promo_pages.id')
            ->get();
        $BannersData = array();
        foreach($promobanners as $banner)
        {
            if(Auth::user()->id < 3282) {
                $promocount = PromoLog::where('url', 'LIKE', '%/promo/' . $banner->alias . '/%')
                    ->where('ref_id', '<', 3282)
                    ->count();
                $promoclickcount = PromoLog::where('url', 'LIKE', '%/promo/' . $banner->alias . '/%')
                    ->where('ref_id', '<', 3282)
                    ->where('status', '>', 0)
                    ->count();
                if($promoclickcount > 0) {
                    $clicktrue = round(($promoclickcount/$promocount)*100, 0);
                } else {
                    $clicktrue = 0;
                }

            } else {
                $promocount = PromoLog::where('url', 'LIKE', '%/promo/' . $banner->alias . '/%')
                    ->where('ref_id', '=', Auth::user()->id)
                    ->count();
                $promoclickcount = PromoLog::where('url', 'LIKE', '%/promo/' . $banner->alias . '/%')
                    ->where('ref_id', '=', Auth::user()->id)
                    ->where('status', '>', 0)
                    ->count();
                if($promoclickcount > 0) {
                    $clicktrue = round(($promoclickcount/$promocount)*100, 0);
                } else {
                    $clicktrue = 0;
                }
            }

            $BannersData[] = (object)array('alias'=>$banner->alias,'image'=>$banner->image,
                'totalView'=>$promocount,'clicktru'=>$clicktrue,'video'=>$banner->video,'title'=>$banner->title,'type'=>$banner->type,
                'description'=>$banner->description
            );
        }
        $promobanners = $BannersData;


        return view('member.promo_banner')->with('promobanners',$promobanners)->with('promocount',$promocount);
    }

    public function manage_subscribers()
    {
        $refid = Auth::user()->id;
        if($refid < 3282) {
            $newsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '<', 3282)
                ->where('contacted', '<', 1)
                ->where('kiv', '<', 1)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $contactedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '<', 3282)
                ->where('contacted', '>', 0)
                ->where('kiv', '<', 1)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $kivsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '<', 3282)
                ->where('kiv', '>', 0)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $uninterestedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '<', 3282)
                ->where('uninterested', '>', 0)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $closedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '<', 3282)
                ->where('closed', '>', 0)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
        } else {
            $newsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '=', $refid)
                ->where('contacted', '<', 1)
                ->where('kiv', '<', 1)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $contactedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '=', $refid)
                ->where('contacted', '>', 0)
                ->where('kiv', '<', 1)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $kivsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '=', $refid)
                ->where('kiv', '>', 0)
                ->where('uninterested', '<', 1)
                ->where('closed', '<', 1)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $uninterestedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '=', $refid)
                ->where('uninterested', '>', 0)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();
            $closedsubs = PromoSubscribers::select('promo_subscribers.*', 'promo_pages.title')
                ->where('ref_id', '=', $refid)
                ->where('closed', '>', 0)
                ->leftJoin('promo_pages','promo_subscribers.page_id','=','promo_pages.id')
                ->get();

        }
        return view('member.promo_subscribers')->with('newsubs',$newsubs)
                                            ->with('contactedsubs',$contactedsubs)
                                            ->with('uninterestedsubs',$uninterestedsubs)
                                            ->with('closedsubs',$closedsubs)
                                            ->with('kivsubs',$kivsubs);
    }
}