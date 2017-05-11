<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Session;
//use Illuminate\Html\HtmlFacade;

use App\User;
use Redirect;
use Crypt;
use App\Classes\ReferralClass;
use Input;
use App\PromoSubscribers;
use App\PromoBanners;
use App\Classes\PromoLogClass;
use Validator;

class PromoController extends Controller
{

    public function subscribe()
    {
        //Validate Start
        $rules = array(
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:promo_subscribers|unique:users',
            'mobile' => 'required|unique:promo_subscribers|unique:users'
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $email = Input::get('email');
        $mobile = Input::get('mobile');

        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator)
                ->withInput();

        } else {

            $subscriber = new PromoSubscribers();
            $subscriber->firstname = $firstname;
            $subscriber->lastname = $lastname;
            $subscriber->email = $email;
            $subscriber->mobile = $mobile;
            $subscriber->ref_id = ReferralClass::getReferral()->id;
            $subscriber->save();

            return Redirect::back()->with('success', '<br><br><h4>'.trans('landing._thank_you_1').'</h4> <p>'.trans('landing._thank_you_2').'</p><p>'.trans('landing._thank_you_3').'</p>
<p>'.trans('landing._thank_you_4').'</p>
<p>'.trans('landing._thank_you_5').'</p>');

        }
    }

}