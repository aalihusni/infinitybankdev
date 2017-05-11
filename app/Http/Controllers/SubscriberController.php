<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\PromoPages;
use App\PromoBanners;
use App\PromoSubscribers;
use Redirect;
use Crypt;
use Auth;
use DB;
use App\Classes\ReferralClass;
use Input;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function update_subscribers()
    {
        $pid = $_POST['pid'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $interest = $_POST['interest'];

        $note = $_POST['note'];

        $prospect = PromoSubscribers::find($pid);
        $prospect->firstname = $firstname;
        $prospect->lastname = $lastname;
        $prospect->email = $email;
        $prospect->mobile = $mobile;
        $prospect->interest = $interest;
        $prospect->note = $note;

        if(!empty($_POST['contacted'])) {
            $prospect->contacted = 1;
        } else {
            $prospect->contacted = 0;
        }
        if(!empty($_POST['followup'])) {
            $prospect->followup = 1;
        } else {
            $prospect->followup = 0;
        }
        if(!empty($_POST['kiv'])) {
            $prospect->kiv = 1;
        } else {
            $prospect->kiv = 0;
        }
        if(!empty($_POST['uninterested'])) {
            $prospect->uninterested = 1;
        } else {
            $prospect->uninterested = 0;
        }
        if(!empty($_POST['closed'])) {
            $prospect->closed = 1;
        } else {
            $prospect->closed = 0;
        }

        $prospect->save();

        return Redirect::to('members/prospect-management')->with('success', 'Prospect has been updated!');
    }

}