<?php
namespace App\Classes;

use App\Settings;
use App\User;
use App\Shares;
use App\Classes\SharesClass;
use App\Classes\BlockioWalletClass;
use App\Classes\BitcoinWalletClass;
use App\MicroPassport;
use App\PassportDiscount;

class MicroPassportClass
{
    public static function calcPassportDiscount($quantity)
    {
        $passport_price = self::getPassportPrice();
        $passport_percent_discount = self::getPassportDiscount($quantity);
        $passport_discount = (($passport_price / 100) * $passport_percent_discount);
        $passport_after_discount = ($passport_price - $passport_discount);
        $passport_total = ($passport_price * $quantity);
        $passport_total_discount = ($passport_discount * $quantity);
        $passport_total_after_discount = ($passport_after_discount * $quantity);

        $return['passport_price'] = $passport_price;
        $return['passport_percent_discount'] = $passport_percent_discount;
        $return['passport_discount'] = $passport_discount;
        $return['passport_after_discount'] = $passport_after_discount;
        $return['passport_total'] = $passport_total;
        $return['passport_total_discount'] = $passport_total_discount;
        $return['passport_total_after_discount'] = $passport_total_after_discount;

        return $return;
    }

    public static function getPassportDiscount($quantity)
    {
        /*
        $passport_discount = PassportDiscount::where('quantity', '<=', $quantity)
            ->orderby('quantity', 'desc')
            ->first();
        if (!empty($passport_discount))
        {
            if (count($passport_discount))
            {
                return $passport_discount->discount;
            }
        }
        */
        return 0;
    }

    public static function getWaitingConfirmations($user_id)
    {
        $waiting_confirmations = BlockioWalletClass::getWaitingConfirmations($user_id, "MP");

        if ($waiting_confirmations)
        {
            return $waiting_confirmations;
        }

        return false;;
    }

    public static function getPassportTransactions($user_id)
    {
        $passport_transactions = MicroPassport::where('user_id', '=', $user_id)
            ->get();

        if (!empty($passport_transactions))
        {
            if (count($passport_transactions)) {
                return $passport_transactions;
            }
        }

        return false;
    }

    public static function getPassportDetails($user_id)
    {
        $passport_balance   = self::getPassportBalance($user_id);
        $passport_price     = self::getPassportPrice();

        $return['passport_balance'] = $passport_balance;
        $return['passport_price']   = $passport_price;

        return $return;
    }

    public static function getPassportBalance($user_id)
    {
        $user = User::find($user_id);

        if ($user)
        {
            $passport_balance = $user->micro_passport_balance;

            return $passport_balance;
        } else {
            return false;
        }
    }

    public static function getPassportPrice()
    {
        $passport_price = Settings::select('micro_passport_price')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($passport_price)
        {
            return $passport_price->micro_passport_price;
        } else {
            return false;
        }
    }

    public static function getPaymentDetails($user_id, $passport_quantity)
    {
        $calc_passport_discount         = self::calcPassportDiscount($passport_quantity);
        $passport_price                 = $calc_passport_discount['passport_after_discount'];
        $value_in_btc                   = ($passport_quantity * $passport_price);
        $return['receiving_address']    = BlockioWalletClass::getReceivingAddressUser(1, $user_id, "MP", $value_in_btc, $passport_quantity)['receiving_address'];
        $return['value_in_btc']         = $value_in_btc;

        return $return;
    }

    public static function setPassportBalance($user_id, $passport_quantity, $passport_description = "", $secret = "")
    {
        if($passport_quantity <> 0) {
            $user = User::find($user_id);

            if (!empty($secret)) {
                echo $secret."#############<br>";
                $passport = MicroPassport::where('user_id', '=', $user_id)
                    ->where('secret', '=', $secret)
                    ->get();

                if (count($passport))
                {
                    return false;
                }
            }

            if ($user) {
                $passport = new MicroPassport();
                $passport->user_id = $user_id;
                if($passport_quantity > 0)
                {
                    if (empty($passport_description)) {
                        $passport->description = "Purchased";
                    } else {
                        $passport->description = $passport_description;
                    }
                    $passport->debit = $passport_quantity;
                }
                if($passport_quantity < 0)
                {
                    $passport->description = $passport_description;
                    $passport->credit = $passport_quantity;
                }
                if (!empty($secret)) {
                    $passport->secret = $secret;
                }
                $passport->save();

                $passport_id = $passport->id;

                $passport_balance = $user->micro_passport_balance;
                $passport_balance = $passport_balance + $passport_quantity;

                $user->micro_passport_balance = $passport_balance;
                $user->save();

                TrailLogClass::addTrailLog($user_id, "Passport", "passport_description:".$passport_description."|passport_quantity:".$passport_quantity);

                return $passport_id;
            }
        }
    }

    public static function addPassportBonus($user_id, $shares_type_id)
    {
        $user = User::find($user_id);
        $passport = Settings::orderby('id', 'desc')->first();
        $value_in_btc = $passport->micro_passport_price;
        $hierarchy = str_replace("#", "", $user->hierarchy_bank);

        $hierarchy = explode("|", $hierarchy);
        for ($i = 1; $i < count($hierarchy); $i++) {
            $upline_user_id = $hierarchy[$i];

            $upline = User::find($upline_user_id);
            $upline_user_class = $upline->user_class;
            $percent = 0;
            $shares_type = "";

            switch ($i) {
                case '1':
                    $percent = 10;
                    $shares_type = "MPR";
                    break;
                case '2':
                    if ($upline_user_class >= 2) {
                        $percent = 5;
                        $shares_type = "MPO";
                    }
                    break;
                case '3':
                    if ($upline_user_class >= 3) {
                        $percent = 3;
                        $shares_type = "MPO";
                    }
                    break;
                case '4':
                    if ($upline_user_class >= 4) {
                        $percent = 1;
                        $shares_type = "MPO";
                    }
                    break;
                case '5':
                    if ($upline_user_class >= 5) {
                        $percent = 0.5;
                        $shares_type = "MPO";
                    }
                    break;
                case '6':
                    if ($upline_user_class >= 6) {
                        $percent = 0.1;
                        $shares_type = "MPO";
                    }
                    break;
                case '7':
                    if ($upline_user_class >= 7) {
                        $percent = 0.05;
                        $shares_type = "MPO";
                    }
                    break;
                default:
                    if ($upline_user_class >= 8) {
                        $percent = 0.01;
                        $shares_type = "MPO";
                    }
            }

            if ($percent > 0) {
                $percent_value_in_btc = (($value_in_btc / 100) * $percent);
                $status = 1;
                $secret = BitcoinWalletClass::generateSecret();
                SharesClass::setShares($upline_user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $percent_value_in_btc);
            }
        }
    }
}