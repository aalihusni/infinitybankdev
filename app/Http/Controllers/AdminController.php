<?php

namespace App\Http\Controllers;

use Auth;
use Redirect;
use Crypt;
use Input;
use App\User;
use App\BitcoinBlockioWalletReceiving;
use App\Classes\BitcoinWalletClass;
use App\Classes\PAGBClass;
use App\Classes\EmailClass;
use App\Classes\PassportClass;
use App\Classes\PAGBFixClass;
use App\Classes\PHGHClass;
use App\Classes\AdminClass;
use DB;
use Excel;
use Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => 'quick_login']);
    }

    public function quick_login($id)
    {
        if (isset($_COOKIE['cookieFile'])) {
            $cookieadmin = Crypt::decrypt($_COOKIE['cookieFile']);
            if ($cookieadmin) {
                if ($id == 1) {
                    Auth::loginUsingId($id);
                    return Redirect::to('admin/home');
                } else {
                    if (Auth::user()->id == 1) {
                        Auth::loginUsingId($id);
                        return Redirect::to('members/home');
                    }
                }
            }
        }

        return Redirect::to('login');
    }

    public function users_list($user_type, $filter_type = "", $filter_value = "")
    {
        if ($user_type == "pool")
        {
            $user_type_no = "2";
        }
        if ($user_type == "member")
        {
            $user_type_no = "2";
        }
        if ($user_type == "non-member")
        {
            $user_type_no = "3";
        }


        $sql = User::where('user_type', '=', $user_type_no);
        if ($user_type == "pool") {
            $sql->where('id', '<=', 3281);
        } else {
            $sql->where('id', '>', 3281);
        }
        if (!empty($filter_type))
        {
            if ($filter_type == 'id' || $filter_type == 'upline_user_id' || $filter_type == 'referral_user_id' || $filter_type == 'global_level') {
                $sql->where($filter_type, '=', $filter_value);
            }
            elseif ($filter_type == 'hierarchy' || $filter_type == 'hierarchy_bank')
            {
                $sql->where($filter_type, 'like', '%#' . $filter_value . '#%');
            } else {
                $sql->where($filter_type, 'like', '%' . $filter_value . '%');
            }
        }
        $user_count = $sql->count();

        $users = $sql->orderby('created_at', 'desc')
            ->paginate(100);

        if ($filter_type == 'global_level' && $filter_value == "9")
        {
            if (!empty($users)) {
                if (count($users)) {
                    foreach ($users as $user) {
                        $count = User::where('hierarchy', 'like', '%'.$user->id.'%')
                            ->count();
                        $downline[$user->id] = ($count - 1);
                        $count = User::where('referral_user_id', '=', $user->id)
                            ->count();
                        $referral[$user->id] = $count;
                    }
                }
            }
        } else {
            $downline = "";
            $referral = "";
        }

        return view('admin.users')->with('user_count', $user_count)->with('user_type', $user_type)->with('user_type_no', $user_type_no)->with('users', $users)->with('filter_type', $filter_type)->with('filter_value', $filter_value)->with('downline', $downline)->with('referral', $referral);
    }

    public function users_unapproved($user_type, $filter_type = "", $filter_value = "")
    {
        if ($user_type == "pool")
        {
            $user_type_no = "2";
        }
        if ($user_type == "member")
        {
            $user_type_no = "2";
        }
        if ($user_type == "non-member")
        {
            $user_type_no = "3";
        }


        $sql = User::where('user_type', '=', $user_type_no);
        if ($user_type == "pool") {
            $sql->where('id', '<=', 3281);
        } else {
            $sql->where('id', '>', 3281);
            $sql->where(function($qr){

                $qr->where('id_verify_status', '=', 1);
                $qr->orWhere('selfie_verify_status', '=', 1);
            });

           // $sql->where('id_verify_status', '=', 1);
            //$sql->orWhere('selfie_verify_status', '=', 1);
        }
        if (!empty($filter_type))
        {
            if ($filter_type == 'id' || $filter_type == 'upline_user_id' || $filter_type == 'referral_user_id' || $filter_type == 'global_level') {
                $sql->where($filter_type, '=', $filter_value);
            }
            elseif ($filter_type == 'hierarchy' || $filter_type == 'hierarchy_bank')
            {
                $sql->where($filter_type, 'like', '%#' . $filter_value . '#%');
            } else {
                $sql->where($filter_type, 'like', '%' . $filter_value . '%');
            }
        }
        $user_count = $sql->count();

        $users = $sql->orderby('created_at', 'desc')
            ->paginate(100);

        if ($filter_type == 'global_level' && $filter_value == "9")
        {
            if (!empty($users)) {
                if (count($users)) {
                    foreach ($users as $user) {
                        $count = User::where('hierarchy', 'like', '%'.$user->id.'%')
                            ->count();
                        $downline[$user->id] = ($count - 1);
                        $count = User::where('referral_user_id', '=', $user->id)
                            ->count();
                        $referral[$user->id] = $count;
                    }
                }
            }
        } else {
            $downline = "";
            $referral = "";
        }

        return view('admin.users-approval')->with('user_count', $user_count)->with('user_type', $user_type)->with('user_type_no', $user_type_no)->with('users', $users)->with('filter_type', $filter_type)->with('filter_value', $filter_value)->with('downline', $downline)->with('referral', $referral);
    }

    public function approve_id()
    {
        $user = User::find($_POST['id']);
        $email = $user->email;
        $template = 'emails.'.$_POST['verify'].'_verification_approved';
        $data = array(
            'username'=>$user->alias
        );
        if($_POST['verify'] == 'id')
        {
            $user-> id_verify_status = "2";
            $subject = $user->alias.", your ID verification has been approved!";
            EmailClass::send_email($template, $email, $subject, $data, '1');
        }
        elseif($_POST['verify'] == 'selfie')
        {
            $user-> selfie_verify_status = "2";
            $subject = $user->alias.", your Selfie verification has been approved!";
            EmailClass::send_email($template, $email, $subject, $data, '1');
        }
        elseif($_POST['verify'] == 'both')
        {
            $user-> id_verify_status = "2";
            $user-> selfie_verify_status = "2";

            EmailClass::send_email('emails.id_verification_approved', $email, $user->alias.", your ID verification has been approved!", $data, '1');
            EmailClass::send_email('emails.id_verification_approved', $email, $user->alias.", your Selfie verification has been approved!", $data, '1');
        }
        $user-> save();


        return '1';
    }

    public function reject_id()
    {
        $user = User::find($_POST['id']);
        $email = $user->email;
        $template = 'emails.'.$_POST['verify'].'_verification_reject';
        $data = array(
            'username'=>$user->alias,
            'reason'=>$_POST['reason']
        );
        if($_POST['verify'] == 'id')
        {
            $user-> id_verify_status = "0";
            $subject = $user->alias.", your ID verification has been rejected!";
            EmailClass::send_email($template, $email, $subject, $data, '1');
        }
        elseif($_POST['verify'] == 'selfie')
        {
            $user-> selfie_verify_status = "0";
            $subject = $user->alias.", your Selfie verification has been rejected!";
            EmailClass::send_email($template, $email, $subject, $data, '1');
        }
        $user-> save();
        return '1';
    }

    public function assign_upline()
    {

        $upline_id = $_POST['upline_id'];
        $user_id = $_POST['id'];

        if(empty($_POST['upline_id']))
        {
            return Redirect::back()->withErrors('Upline ID must not be empty');
        }

        //Validate
        $upline = User::find($upline_id);
        $available_tree = $upline->tree_slot;
        $upline_hierarchy = $upline->hierarchy;
        $upline_global_level = $upline->global_level;

        if($available_tree>=3)
        {
            return Redirect::back()->withErrors('No empty slot on this user');
        }
        elseif($upline->user_type == 3)
        {
            return Redirect::back()->withErrors('Upline you entered is non member');
        }
        else
        {
            $treepos = PAGBClass::getUplineEmptyTreePosition($upline_id);

            $upline->tree_slot = $available_tree+1;
            $upline->save();

            $user = User::find($user_id);
            $user->user_type = "2";
            $user->user_class = "1";
            $user->tree_position = $treepos;
            $user->upline_user_id = $upline_id;
            $user->locked_upline_user_id = "0";
            $user->locked_upline_at = "0000-00-00 00:00:00";
            $user->global_level = $upline_global_level+1;
            $user->hierarchy = "#".$user_id."#|".$upline_hierarchy;
            $user->save();

            $template = 'emails.immigrant';
            $subject = "Welcome $user->alias, you are now an Immigrant!";
            $data = array('username'=>$user->alias,'email'=>$user->email);
            EmailClass::send_email($template, $user->email, $subject, $data, '0');

            return Redirect::back()->with('success','Upline has been assigned to this user!');
        }

    }

    public function move_network()
    {
        $user_id = $_POST['id'];
        $upline_user_id = $_POST['upline_user_id'];
        $tree_position = $_POST['tree_position'];

        if (empty($upline_user_id)) {
            return Redirect::back()->withErrors('Upline ID must not be empty');
        }

        DB::beginTransaction();

        $upline = User::find($upline_user_id);
        if (empty($upline) || !count($upline)) {
            return Redirect::back()->withErrors('Upline is invalid');
        }
        $checkpost = User::where('upline_user_id', '=', $upline_user_id)
            ->where('tree_position', '=', $tree_position)
            ->count();

        if ($upline->tree_slot >= 3) {
            return Redirect::back()->withErrors('No empty slot on this user');
        } elseif ($upline->user_type == 3) {
            return Redirect::back()->withErrors('Upline you entered is non member');
        } elseif ($checkpost == 1) {
            return Redirect::back()->withErrors('This position is taken');
        }

        //echo "Update New Upline - " . $upline->alias . "<br>";

        $upline->tree_slot = $upline->tree_slot + 1;
        $global_level = $upline->global_level;
        $global_level_bank = $upline->global_level_bank;
        $hierarchy = $upline->hierarchy;
        $hierarchy_bank = $upline->hierarchy_bank;
        $upline->save();

        $user = User::find($user_id);

        /*
        echo "Update User - " . $user->alias . "<br>";
        echo $user->global_level . " | " . ($global_level + 1) . "<br>";
        echo $user->hierarchy . " | " . "#" . $user->id . "#|" . $hierarchy . "<br>";
        */

        $old_upline_user_id = $user->upline_user_id;
        $user->upline_user_id = $upline_user_id;
        $user->tree_position = $tree_position;
        $user->global_level = $global_level + 1;
        //$user->global_level_bank = $global_level_bank + 1;
        $user->hierarchy = "#" . $user->id . "#|" . $hierarchy;
        //$user->hierarchy_bank = "#" . $user->id . "#|" . $hierarchy_bank;
        $user->save();

        $old_upline = User::find($old_upline_user_id);

        //echo "Update Old Upline - " . $old_upline->alias . "<br>";

        $old_upline->tree_slot = $old_upline->tree_slot - 1;
        $old_upline->save();

        $this->move_network_downline($user->id, $user->global_level, $user->hierarchy, $user->global_level_bank, $user->hierarchy_bank);
        DB::commit();

        return Redirect::back()->with('success', 'Network has been moved for this user!');
    }

    public function move_network_downline($user_id, $global_level, $hierarchy, $global_level_bank, $hierarchy_bank)
    {
        $users = User::where('upline_user_id', '=', $user_id)
            ->get();
        if (!empty($users))
        {
            if (count($users))
            {
                foreach ($users as $user)
                {
                    echo "Update Downline - " . $user->alias . "<br>";
                    echo $user->global_level . " | " . ($global_level + 1) . "<br>";
                    echo $user->hierarchy . " | " . "#" . $user->id . "#|" . $hierarchy . "<br>";
                    //echo $user->global_level_bank . " | " . ($global_level_bank + 1) . "<br>";
                    //echo $user->hierarchy_bank . " | " . "#" . $user->id . "#|" . $hierarchy_bank . "<br>";

                    $user->global_level = $global_level + 1;
                    $user->hierarchy = "#" . $user->id . "#|" . $hierarchy;
                    //$user->global_level_bank = $global_level_bank + 1;
                    //$user->hierarchy_bank = "#" . $user->id . "#|" . $hierarchy_bank;
                    $user->save();

                    $this->move_network_downline($user->id, $user->global_level, $user->hierarchy, $user->global_level_bank, $user->hierarchy_bank);
                }
            }
        }
    }

    public function reassign_referral()
    {
        $users = DB::table('users as a')
            ->select('a.*','b.user_type as b_user_type','b.hierarchy_bank as b_hierarchy_bank')
            ->leftjoin(DB::raw('users b'), 'a.referral_user_id', '=', 'b.id')
            ->where('a.referral_user_id', '>', '3281')
            ->where('a.user_type', '=', '3')
            ->where('b.user_type', '=', '3')
            ->get();
        if (!empty($users))
        {
            if (count($users))
            {
                foreach ($users as $user)
                {
                    echo $user->alias."<br>";
                    $hierarchy_bank = $user->hierarchy_bank;
                    $hierarchy_bank = str_replace('#','',$hierarchy_bank);
                    $hierarchy_bank = explode('|',$hierarchy_bank);

                    for ($i = 0; $i < count($hierarchy_bank); $i++)
                    {
                        $check = User::find($hierarchy_bank[$i]);
                        if ($check->user_type == 2)
                        {
                            echo $hierarchy_bank[$i].' | Referral: '.$check->alias.' | user_type: '.$check->user_type."<br>";
                            $update = User::find($user->id);
                            $update->referral_user_id = $check->id;
                            $update->hierarchy_bank = '#'.$user->id.'#|'.$check->hierarchy_bank;
                            $update->save();
                            break;
                        }
                    }
                }
            }
        }
    }

    public function transfer_passport()
    {

        $passport = $_POST['passport'];
        $user_id = $_POST['id'];

        if(empty($_POST['passport']))
        {
            return Redirect::back()->withErrors('Passport must not be empty');
        }

        PassportClass::setPassportBalance($user_id, $passport, "Free (From Admin)");

        return Redirect::back()->with('success','Passport has been transfered to this user!');
    }

    public function update_referrer()
    {
        $referrer_id = $_POST['referrer_id'];
        $user_id = $_POST['id'];

        $referrer = User::find($referrer_id);

        $update = User::find($user_id);
        $update->referral_user_id = $referrer->id;
        $update->hierarchy_bank = '#' . $update->id . '#|' . $referrer->hierarchy_bank;
        $update->save();

        return Redirect::back()->with('success','Referrer has been updated for this user!');
    }

    public function reclaim_account()
    {
        $user_id = $_POST['id'];

        DB::beginTransaction();
        $update = User::find($user_id);
        $update->upline_user_id = 0;
        $update->referral_user_id = 2;
        $update->user_type = 3;
        $update->user_class = 0;
        $update->passport_balance = 1;
        $update->save();

        $referrer = User::find(2);

        $referrals = User::where('referral_user_id', '=', $user_id)
            ->get();
        if (!empty($referrals))
        {
            if (count($referrals))
            {
                foreach ($referrals as $referral)
                {
                    $referral->referral_user_id = $referrer->id;
                    $referral->hierarchy_bank = "#".$referral->id."#|".$referrer->hierarchy_bank;
                    $referral->global_level_bank = ($referrer->global_level_bank + 1);
                    $referral->save();
                }
            }
        }
        DB::commit();

        return Redirect::back()->with('success','Account has been reclaimed.');
    }

    public function image_create_album()
    {
        $title = $_POST['title'];
        $country = $_POST['country'];
        $description = $_POST['description'];

        echo "$title:$country:$description";

        //return Redirect::back()->with('success','New album created.');
    }

    public function change_receiving_status()
    {
        $id = $_POST['id'];
        $receiving = BitcoinBlockioWalletReceiving::find($id);
        $receiving->status = 1;
        $receiving->save();

        return Redirect::back()->with('success','Status has been updated for this id!');
    }

    public function pagb_fix()
    {
        $id = $_POST['id'];
        PAGBFixClass::addPAGBFix($id);

        return Redirect::back()->with('success','Status has been updated for this id!');
    }

    public function help_upload()
    {
        //Validate Start
        $rules = array(
            'file'             => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);
        //Validation End

        $file = Input::file('file');

        if ($validator->fails()) {

            return Redirect::to('admin/help')
                ->withErrors($validator);
        } else {

            Excel::load($file, function($reader) {

                // Getting all results
                $results = $reader->get();

                DB::beginTransaction();
                foreach($results as $sheet)
                {
                    $user_id = $sheet->get('id');
                    $wallet_address = $sheet->get('address');
                    $value_in_btc = number_format($sheet->get('value'),8);
                    $secret = BitcoinWalletClass::generateSecret();
                    $datetime = Carbon::now()->addDays(-15);

                    echo $user_id." | ".$wallet_address." | ".$value_in_btc." | ".$secret." | ".$datetime."<br>";

                    if ($user_id >= 2 and $user_id <= 3281) {
                        if (BitcoinWalletClass::validBitcoinAddress(trim($wallet_address))) {
                            $user = User::find($user_id);
                            $user->wallet_address = trim($wallet_address);
                            $user->save();

                            PHGHClass::addGH($user_id, $value_in_btc, $secret, $datetime);
                        } else {
                            echo "Invalid Wallet Address !<br>";
                        }
                    } else {
                        echo "Invalid User ID !<br>";
                    }
                }
                DB::commit();

            });

        }
    }

    public function settings_hierarchy($type, $set)
    {
        AdminClass::setHierarchy($type, $set);
    }
}