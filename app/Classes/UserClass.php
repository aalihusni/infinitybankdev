<?php
namespace App\Classes;

use App\User;
use App\UserClasses;
use App\Classes\EmailClass;
use App\Classes\ReferralClass;
use App\Classes\PassportClass;
use App\Classes\PAGBClass;
use App\Classes\TrailLogClass;
use Carbon\Carbon;
use Mail;
use Crypt;
use Hash;
use DB;

class UserClass
{
    public static function checkAlias($alias)
    {
        $user = User::where('alias', '=', $alias)
            ->get();
        if (!empty($user))
        {
            if (count($user))
            {
                return "KO";
            }
        }

        return "OK";
    }

    public static function getUserDetails($user_id)
    {
        $user = User::find($user_id);
        $user_class = $user->user_class;
        $upline_user_id = $user->upline_user_id;
        $upline_user_class = "";
        $upline_diff_class = "";
        if ($upline_user_id) {
            $upline = User::find($upline_user_id);
            $upline_user_class = $upline->user_class;
            $upline_diff_class = ($upline_user_class - $user_class);
        }

        for ($i=1; $i <9 ; $i++)
        {
            if ($i == $user_class) {
                $primary['primary' . $i] = "primary";
            } else {
                $primary['primary' . $i] = "";
            }
        }

        $return['id'] = $user->id;
        $return['cryptid'] = Crypt::encrypt($user->id);
        $return['firstname'] = $user->firstname;
        $return['lastame'] = $user->lastame;
        $return['email'] = $user->email;
        $return['mobile'] = $user->mobile;
        $return['alias'] = $user->alias;
        $return['user_class'] = $user_class;
        $return['user_type'] = $user->user_type;
        $return['wallet_address'] = $user->wallet_address;
        $return['referral_user_id'] = $user->referral_user_id;
        $return['upline_user_id'] = $upline_user_id;
        $return['upline_user_class'] = $upline_user_class;
        $return['upline_diff_class'] = $upline_diff_class;
        $return['passport_balance'] = $user->passport_balance;
        $return['id_verify_status'] = $user->id_verify_status;
        $return['selfie_verify_status'] = $user->selfie_verify_status;
        $return['created_at'] = $user->created_at;

        $return = array_merge($return, PAGBClass::getClassDetails($user_class), $primary);

        return $return;
    }

    public static function getUserClass($user_id)
    {
        $user_class = User::find($user_id)->user_class;
        $user_class_name = UserClasses::where('class', '=', $user_class)->first()->name;

        $return['user_class'] = $user_class;
        $return['user_class_name'] = $user_class_name;

        return $return;
    }

    public static function getAlias($user_id)
    {
        $user = User::find($user_id);
        $alias = $user->alias;

        return $alias;
    }

    public static function setAlias($user_id, $alias)
    {
        $user = User::find($user_id);
        TrailLogClass::addTrailLog($user_id, "Update Alias", $alias, $user->alias);
        $user->alias = $alias;
        $user->save();
    }

    public static function setWalletAddress($user_id, $wallet_address)
    {
        $user = User::find($user_id);
        TrailLogClass::addTrailLog($user_id, "Update Wallet Address", $wallet_address, $user->wallet_address);
        $user->wallet_address = $wallet_address;
        $user->save();
    }

    public static function signUp($email, $password, $onbehalf_user_id = "", $sendemail = "1")
    {
        //Get referral
        if (empty($onbehalf_user_id)) {
            $referral = ReferralClass::getReferral();
            $referral_position = ReferralClass::getPosition();

            if ($referral->id < 1095) {
                $referral = User::find(2);
            }
        } else {
            $referral = User::find($onbehalf_user_id);
            $referral_position = "";
        }

        //Generate and validate email verification code
        $emailverificationcode = self::generate_email_verification();
        $password = Hash::make($password);

        $user = new User();
        $user->email = strtolower($email);
        $user->email_verify_code = $emailverificationcode;
        $user->email_verify_status = '0';
        $user->user_type = '3';
        $user->password = $password;
        $user->alias = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 8);
        if (!empty($onbehalf_user_id))
        {
            $user->onbehalf_user_id = $onbehalf_user_id;
        }
        $user->referral_user_id = $referral->id;
        $user->global_level_bank = ($referral->global_level_bank + 1);
        $user->profile_pic = "no_img.jpg";
        $user->save();

        $user_id = $user->id;

        $user->hierarchy_bank = "#".$user_id."#|".$referral->hierarchy_bank;
        $user->save();

        TrailLogClass::addTrailLog($user_id, "Register", strtolower($email));

        //PassportClass::setPassportBalance($user_id, 1, "Free");

        $email_enc = Crypt::encrypt($email);

        $data = array('email' => $email, 'verificationcode' => $emailverificationcode);

        $template = 'emails.signup';
        $subject = 'Thank you for registering with BitRegion. Please confirm your email address.';

        EmailClass::send_email($template, $email, $subject, $data, $sendemail);

        $return['user_id'] = $user_id;
        $return['email_enc'] = $email_enc;

        return $return;
    }

    public static function generate_email_verification()
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

    public static function reassignReferralHierarchy($user_id)
    {
        $upline = User::find($user_id);
        $downlines = User::where('referral_user_id', '=', $user_id)
            ->get();

        echo Carbon::now()." : ID = ".$user_id." | Downlines = ".count($downlines)."<br>\r\n";

        if (!empty($downlines))
        {
            if (count($downlines))
            {
                foreach ($downlines as $downline)
                {
                    echo Carbon::now()." : "."#".$downline->id."#|".$upline->hierarchy_bank."<br>\r\n";
                    $downline->hierarchy_bank = "#".$downline->id."#|".$upline->hierarchy_bank;
                    $downline->global_level_bank = ($upline->global_level_bank + 1);
                    //$downline->updated_at = Carbon::now();
                    $downline->save();

                    self::reassignReferralHierarchy($downline->id);
                }
            }
        }
    }

    public static function reassignPlacementHierarchy($user_id)
    {
        $upline = User::find($user_id);
        $downlines = User::where('upline_user_id', '=', $user_id)
            ->get();

        echo Carbon::now()." : ID = ".$user_id." | Downlines = ".count($downlines)."<br>\r\n";

        if (!empty($downlines))
        {
            if (count($downlines))
            {
                foreach ($downlines as $downline)
                {
                    echo Carbon::now()." : "."#".$downline->id."#|".$upline->hierarchy."<br>\r\n";
                    $downline->hierarchy = "#".$downline->id."#|".$upline->hierarchy;
                    $downline->global_level = ($upline->global_level + 1);
                    //$downline->updated_at = Carbon::now();
                    $downline->save();

                    self::reassignPlacementHierarchy($downline->id);
                }
            }
        }
    }

    public static function movePlacement($upline, $downline1 = "", $downline2 = "", $downline3 = "")
    {
        echo "#1<br>";
        DB::beginTransaction();
        $downlines = User::where('upline_user_id','=', $upline)
            ->get();
        $i=0;
        foreach ($downlines as $downline)
        {
            $i++;

        }








        for ($i = 1; $i < 4; $i++) {
            $var = "downline".$i;
            if ($$var > 0) {
                echo "#".$$var."<br>";
                $downline = User::find($$var);
                if ($downline->tree_position != $i) {
                    echo "#2<br>";
                    if ($downline->upline_user_id == $upline) {
                        $count = User::where('upline_user_id', '=', $$var)->count();
                        if ($count == 0) {
                            $logtitle = "Move Placement";
                            $logfrom = $downline->tree_position;
                            $logto = $i;
                            TrailLogClass::addTrailLog($upline, $logtitle, $logto, $logfrom);

                            $downline->tree_position = $i;
                            $downline->save();
                        } else {
                            DB::rollBack();
                            return false;
                        }
                    } else {
                        DB::rollBack();
                        return false;
                    }
                }
            }
        }
        echo "#3<br>";
        DB::commit();
        return true;
    }
}