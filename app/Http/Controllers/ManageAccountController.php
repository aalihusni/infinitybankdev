<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use Redirect;
use Validator;
use DB;
use URL;
use Crypt;
use App\User;
use App\Classes\MemberClass;
use App\Classes\UserClass;
use App\Classes\PAGBClass;
use App\Classes\PHGHClass;
use App\Classes\SharesClass;
use App\Classes\BitcoinWalletClass;
use App\Classes\CheckEmailClass;

class ManageAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function signup()
    {
        //Validate Start
        $rules = array(
            'email'        => array('email','required','unique:users','regex:/^[^+]+$/'),
            'password'     => 'required',
            'repassword'   => 'required|same:password',
            'alias'        => 'required|alpha_num|min:5|max:12',
            'firstname'    => 'required',
            'lastname'     => 'required',
            'country_code' => 'required',
            'wallet_address' => 'required','unique:users'
        );

        $messages = array( 'wallet_address.unique' => 'The wallet address has already been used.' );
        $validator = Validator::make(Input::all(), $rules, $messages);
        //Validation End

        //Declare Input Variables
        $email = Input::get('email');
        $password = Input::get('password');
        $alias = Input::get('alias');
        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $country_code = Input::get('country_code');
        $wallet_address = Input::get('wallet_address');
        $upline = Input::get('upline');
        $onbehalf_user_id = Auth::user()->id;

        if ($validator->fails()) {

            return Redirect::to('/members/new-member')
                ->withErrors($validator)
                ->withInput(Input::except('password', 'repassword'));

        } else {
            if (!BitcoinWalletClass::validBitcoinAddress($wallet_address))
            {
                return Redirect::back()->withErrors('Invalid Bitcoin Wallet Address')->withInput(Input::except('password', 'repassword'));
            }

            /*
            $checkemail = CheckEmailClass::verifyEmail($email);
            if ($checkemail == "invalid") {
                return Redirect::to('/members/new-member')
                    ->withErrors("Email does not exist, please check if there is a typing error in the email and try again.")
                    ->withInput(Input::except('password', 'repassword'));
            }
            */
            DB::beginTransaction();

            //Register New Member
            $sign_up = UserClass::signUp($email, $password, $onbehalf_user_id);
            $user_id = $sign_up['user_id'];

            //Complete Profile
            MemberClass::setCompleteProfile($user_id, $alias, $firstname, $lastname, $country_code, $wallet_address);

            //Upgrade
            if (!empty($upline)) {
                //Manual Placement
                $empty_slot = PAGBClass::getEmptyTreeSlot($upline, Auth::user()->id);
                if (!empty($empty_slot)) {
                    $upline = User::where('alias', '=', $upline)->first();
                    $upline_user_id = $upline->id;
                    $upline_hierarchy = $upline->hierarchy;
                    $upline_global_level = $upline->global_level;

                    $position = Input::get('position');
                    if (!empty($position)) {
                        if ($empty_slot['position']['slot' . $position] == 0) {
                            $empty_tree_position = $position;

                            $locked_status = PAGBClass::setLockedQualifiedUplineUserID($user_id, $upline_user_id, $upline_hierarchy, $upline_global_level, $empty_tree_position, $onbehalf_user_id);
                            if (isset($locked_status['error'])) return Redirect::back()->withErrors($locked_status['error']);
                        } else {
                            return Redirect::back()->withErrors('Position taken');
                        }
                    } else {
                        return Redirect::back()->withErrors('Position not selected');
                    }
                } else {
                    return Redirect::back()->withErrors('Position full');
                }
            } else {
                //Auto Placement
                $locked_status = PAGBClass::getLockedQualifiedUplineUserID($user_id);

                if (isset($locked_status['error'])) return Redirect::back()->withErrors($locked_status['error']);
            }

            DB::commit();
            return Redirect::to(URL::to('/').'/members/manage-account/'.Crypt::encrypt($user_id))->with('Success','Please make payment within 24 hours');
        }
    }

    public function update_wallet()
    {
        //Validate Start
        $rules = array(
            'wallet_address'             => 'required|unique:users'
        );

        $messages = array( 'wallet_address.unique' => 'The wallet address has already been used.' );
        $validator = Validator::make(Input::all(), $rules, $messages);
        //Validation End

        $cryptid = Input::get('id');
        $user_id = Crypt::decrypt($cryptid);
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

    public function provide_help($user_id, $from, $value_in_btc, $secret, $onbehalf_user_id = "")
    {
        $cryptid = $user_id;
        $user_id = Crypt::decrypt($user_id);
        $user = User::find($user_id);

        if ($user->user_type == 3)
        {
            return Redirect::back()->withErrors("User is not eligible to 'Provide Help' !")->with('tab', 'bank');
        }

        if (!empty($onbehalf_user_id))
        {
            $onbehalf_user_id = Crypt::decrypt($onbehalf_user_id);
        } else {
            $onbehalf_user_id = Auth::user()->id;
        }

        if ($value_in_btc > 0) {
            if ($from == "bitcoin") {
                $type = "queue";
            } else {
                return Redirect::back()->withErrors("For 'Manage Account' you can only 'Provide Help' using 'Bitcoin'")->with('tab', 'bank');

                $type = "active";

                $shares_balance = SharesClass::getSharesBalance($user_id);
                if ($shares_balance['shares_balance'] < $value_in_btc) {
                    return Redirect::back()->withErrors('Insufficient shares balance !');
                }
            }
            $ph_status = PHGHClass::createPH($user_id, $value_in_btc, $type, $secret, $onbehalf_user_id);

            if (isset($ph_status['error'])) return Redirect::route($ph_status['redirect'])->withErrors($ph_status['error']);

            return Redirect::to(URL::to('/')."/members/manage-account/".$cryptid."/bank");
        } else {
            return Redirect::back()->withErrors('Value must be greater than zero !');
        }
    }
}