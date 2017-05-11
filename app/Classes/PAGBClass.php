<?php
namespace App\Classes;

use App\User;
use App\UserClasses;
use App\Classes\EmailClass;
use App\Classes\UserClass;
use App\PAGB;
use App\ExcludeUsers;
use App\Classes\BlockchainWalletClass;
use App\Classes\BlockioWalletClass;
use App\Classes\PassportClass;
use Carbon\Carbon;
use DB;

class PAGBClass
{
    public static $admin_user_id = "2";
    public static $admin_wallet_address = "17GGGHWtyi7e1rxnEpcKpE7fHq1UZBguAb";

    public static $upgrade_timeout = 65;
    public static $upgrade_timeout_unit = "minute";

    public static function checkUpgradeTimeout()
    {
        $upgrade_timeout = self::$upgrade_timeout;
        $upgrade_timeout_unit = self::$upgrade_timeout_unit;

        $users = User::where(DB::raw('TIMESTAMPDIFF('.$upgrade_timeout_unit.',`locked_upline_at`,"'.Carbon::now().'")'), '>=', $upgrade_timeout)
            ->where('locked_upline_user_id', '>', '0')
            ->orderby('locked_upline_at', 'asc')
            ->get();

        if (!empty($users))
        {
            if (count($users))
            {
                foreach ($users as $user)
                {
                    $user_id = $user->id;
                    $waiting_confirmations = self::getWaitingConfirmations($user_id);
                    if (!$waiting_confirmations) {
                        self::setUnlockedQualifiedUplineUserID($user_id);
                    }
                }
            }
        }
    }

    public static function getTotalPAGB($user_id)
    {
        $sql = PAGB::select(DB::raw('SUM(value_in_btc) as value_in_btc'));
        $received = $sql->where('user_id', '=', $user_id)->first()->value_in_btc;
        $sql = PAGB::select(DB::raw('SUM(value_in_btc) as value_in_btc'));
        $send = $sql->where('sender_user_id', '=', $user_id)->first()->value_in_btc;
        $members = User::where('hierarchy', 'like', '%'.$user_id.'%')->count();

        $return['send'] = number_format($send,8);
        $return['received'] = number_format($received,8);
        $return['members'] = $members;

        return $return;
    }

    public static function getChartData($user_id)
    {
        $sql = PAGB::select(
            DB::raw('YEAR(`created_at`)as year'),
            DB::raw('LPAD(MONTH(`created_at`), 2, "0") as month'),
            DB::raw('LPAD(DAY(`created_at`), 2, "0") as day'),
            DB::raw('LPAD(HOUR(`created_at`), 2, "0") as hour'),
            DB::raw('LPAD(MINUTE(`created_at`), 2, "0") as min'),
            DB::raw('SUM(value_in_btc) as value_in_btc')
        )
            ->where('user_id', '=', $user_id)
            ->groupby('month')
            ->groupby('day')
            ->groupby('hour')
            ->groupby('min')
            ->orderby('created_at', 'asc');
        $datas = $sql->get();

        $year = "";
        $month = "";
        $day = "";
        $hour = "";
        $min = "";

        $temp = "";
        if (!empty($datas))
        {
            if (count($datas))
            {
                //Prepare Place Holder
                /*
                 * Start ##################################################
                 */
                $date_start = $datas->first();
                $date_start = $date_start->year."-".$date_start->month."-".$date_start->day." ".$date_start->hour.":".$date_start->min.":00";
                $date_start = Carbon::createFromFormat('Y-m-d H:i:s', $date_start);

                $date_last = $datas->last();
                $date_last = $date_last->year."-".$date_last->month."-".$date_last->day." ".$date_last->hour.":".$date_last->min.":00";;
                $date_last = Carbon::createFromFormat('Y-m-d H:i:s', $date_last);

                $total_year = $date_start->diffInYears($date_last);
                $total_month = $date_start->diffInMonths($date_last);
                $total_day = $date_start->diffInDays($date_last);
                $total_hour = $date_start->diffInHours($date_last);
                $total_min = $date_start->diffInMinutes($date_last);

                $yyear = $date_start->year;
                $mmonth = str_pad($date_start->month, 2, '0', STR_PAD_LEFT);
                $dday = str_pad($date_start->day, 2, '0', STR_PAD_LEFT);
                $hhour = str_pad($date_start->hour, 2, '0', STR_PAD_LEFT);

                if ($total_year < 1 && $date_start->year == $date_last->year)
                {
                    if ($total_month < 1 && $date_start->month == $date_last->month)
                    {
                        if ($total_day < 1 && $date_start->day == $date_last->day)
                        {
                            if ($total_hour < 1 && $date_start->hour == $date_last->hour)
                            {
                                $type = "min";
                            } else {
                                $type = "hour";
                            }
                        } else {
                            $type = "day";
                        }
                    } else {
                        $type = "month";
                        $year = $date_start->year;
                        for ($month = $date_start->month; $month < ($date_start->month + $total_month + 1); $month++)
                        {
                            $key = str_pad($year, 2, '0', STR_PAD_LEFT).str_pad($month, 2, '0', STR_PAD_LEFT);
                            $datetime = $yyear;
                            $temp[$key]["key"] = $datetime . "-" . str_pad($month, 2, '0', STR_PAD_LEFT);
                            $temp[$key]["value"] = 0;
                        }
                    }
                } else {
                    $type = "month";
                    for ($year = $date_start->year; $year < ($date_start->year + $total_year + 1); $year++)
                    {
                        if ($year == $date_start->year) {
                            $key = $year;
                            $datetime = $year;
                            $temp[$key]["key"] = $datetime." Total";
                            $temp[$key]["value"] = 0;
                        }
                        elseif ($year == ($date_start->year + $total_year)) {
                            for ($month = 1; $month < ($date_last->month); $month++) {
                                $key = str_pad($year, 2, '0', STR_PAD_LEFT).str_pad($month, 2, '0', STR_PAD_LEFT);
                                $datetime = $year;
                                $temp[$key]["key"] = $datetime . "-" . str_pad($month, 2, '0', STR_PAD_LEFT);
                                $temp[$key]["key"] = Carbon::createFromFormat('Y-m', $temp[$key]["key"])->format("Y M");
                                $temp[$key]["value"] = 0;
                            }
                        } else {
                            for ($month = 1; $month < 13; $month++) {
                                $key = $year;
                                $datetime = $year;
                                $temp[$key]["key"] = $datetime." Total";
                                $temp[$key]["value"] = 0;
                            }
                        }
                    }
                }
                //dd($temp);

                /*
                 * End ##################################################
                 */

                //Fill Data
                /*
                 * Start ##################################################
                 */

                $value = 0;
                $value_first = "";

                foreach ($datas as $data)
                {
                    //Fill variable for 1st loop
                    if (empty($value_first))
                    {
                        $value_first = 1;

                        $year = $data->year;
                        $month = str_pad($data->month, 2, '0', STR_PAD_LEFT);
                        $day = str_pad($data->day, 2, '0', STR_PAD_LEFT);
                        $hour = str_pad($data->hour, 2, '0', STR_PAD_LEFT);
                        $min = str_pad($data->min, 2, '0', STR_PAD_LEFT);
                    }

                    //Fill Data
                    if ($type == "min") {
                        if ($min <> $data->min) {
                            $key = $$type;
                            $datetime = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $min;
                            $temp[$key]["key"] = $datetime;
                            $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d H:i', $temp[$key]["key"])->format("M d h:i A");
                            $temp[$key]["value"] = $value;

                            $value = 0;
                        }
                    }
                    if ($type == "hour") {
                        if ($hour <> $data->hour) {
                            $key = $$type;
                            $datetime = $year . "-" . $month . "-" . $day . " " . $hour;
                            $temp[$key]["key"] = $datetime;
                            $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d H', $temp[$key]["key"])->format("M d h A");
                            $temp[$key]["value"] = $value;

                            $value = 0;
                        }
                    }
                    if ($type == "day") {
                        if ($day <> $data->day) {
                            $key = $$type;
                            $datetime = $year . "-" . $month . "-" . $day;
                            $temp[$key]["key"] = $datetime;
                            $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d', $temp[$key]["key"])->format("jS M Y");
                            $temp[$key]["value"] = $value;

                            $value = 0;
                        }
                    }
                    if ($type == "month") {
                        if ($date_start->year == $date_last->year) {
                            if ($month <> $data->month) {
                                $key = $year . $$type;
                                $datetime = $year . "-" . $month;
                                $temp[$key]["key"] = $datetime;
                                $temp[$key]["key"] = Carbon::createFromFormat('Y-m', $temp[$key]["key"])->format("Y M");
                                $temp[$key]["value"] = $value;

                                $value = 0;
                            }
                        } else {
                            if ($year == ($date_start->year + $total_year)) {
                                if ($month <> $data->month) {
                                    $key = $year . str_pad($month, 2, '0', STR_PAD_LEFT);
                                    $datetime = $year . "-" . $month;
                                    $temp[$key]["key"] = $datetime;
                                    $temp[$key]["key"] = Carbon::createFromFormat('Y-m', $temp[$key]["key"])->format("Y M");
                                    $temp[$key]["value"] = $value;

                                    $value = 0;
                                }
                            } else {
                                if ($year <> $data->year) {
                                    $key = $year;
                                    $datetime = $year;
                                    $temp[$key]["key"] = $datetime." Total";
                                    $temp[$key]["value"] = $value;

                                    $value = 0;
                                }
                            }
                        }
                    }

                    $value = $value + $data->value_in_btc;

                    $year = $data->year;
                    $month = str_pad($data->month, 2, '0', STR_PAD_LEFT);
                    $day = str_pad($data->day, 2, '0', STR_PAD_LEFT);
                    $hour = str_pad($data->hour, 2, '0', STR_PAD_LEFT);
                    $min = str_pad($data->min, 2, '0', STR_PAD_LEFT);
                }

                if ($type == "min") {
                    $key = $$type;
                    $datetime = $year . "-" . $month . "-" . $day . " " . $hour . ":" . $min;
                    $temp[$key]["key"] = $datetime;
                    $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d H:i', $temp[$key]["key"])->format("M d h:i A");
                    $temp[$key]["value"] = $value;
                }
                if ($type == "hour") {
                    $key = $$type;
                    $datetime = $year . "-" . $month . "-" . $day . " " . $hour;
                    $temp[$key]["key"] = $datetime;
                    $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d H', $temp[$key]["key"])->format("M d h A");
                    $temp[$key]["value"] = $value;

                }
                if ($type == "day") {
                    $key = $$type;
                    $datetime = $year . "-" . $month . "-" . $day;
                    $temp[$key]["key"] = $datetime;
                    $temp[$key]["key"] = Carbon::createFromFormat('Y-m-d', $temp[$key]["key"])->format("jS M Y");
                    $temp[$key]["value"] = $value;
                }
                if ($type == "month") {
                    $key = $year.$$type;
                    $datetime = $year . "-" . $month;
                    $temp[$key]["key"] = $datetime;
                    $temp[$key]["key"] = Carbon::createFromFormat('Y-m', $temp[$key]["key"])->format("Y M");
                    $temp[$key]["value"] = $value;
                }

                /*
                 * End ##################################################
                 */
            }
        }

        return $temp;
    }

    public static function getPAGBHistory($user_id)
    {
        $user_classes = UserClasses::get();
        foreach ($user_classes as $user_class)
        {
            $class = "class".$user_class->class;
            $$class = $user_class->name;

        }

        $histories = PAGB::where('user_id', '=', $user_id)
            ->orwhere('sender_user_id', '=', $user_id)
            ->orderby('id', 'desc')
            ->get();

        $return = "";
        if (!empty($histories))
        {
            if (count($histories))
            {
                foreach ($histories as $history) {
                    $data['id'] = $history->id;
                    $data['type'] = $history->type;
                    $data['created_at'] = $history->created_at;
                    $class = "class".$history->new_user_class;
                    $data['new_user_class'] = $history->new_user_class;
                    $data['new_user_class_name'] = $$class;
                    $data['sender_user_id'] = UserClass::getUserDetails($history->sender_user_id)['alias'];
                    $data['user_id'] = UserClass::getUserDetails($history->user_id)['alias'];
                    $data['sender_address'] = $history->sender_address;
                    $data['receiving_address'] = $history->receiving_address;
                    $data['transaction_hash'] = $history->transaction_hash;
                    $data['value_in_btc'] = $history->value_in_btc;

                    $return[] = $data;
                }
            }
        }

        return $return;
    }

    public static function getEmptyTreeSlot($alias, $upline_user_id = "")
    {
        $user = User::where('alias', '=', $alias)
            ->first();
        if (!empty($user))
        {
            if (count($user))
            {
                $user_id = $user->id;
                $user_type = $user->user_type;
                $hierarchy = $user->hierarchy;

                $empty_slot = (3 - $user->tree_slot);
                $empty_position = self::getEmptyTreePosition($user_id);

                $return['slot'] = $empty_slot;
                $return['position'] = $empty_position;

                if (!empty($upline_user_id)) {
                    if ($user_type == 2) {
                        if (strpos($hierarchy, "#" . $upline_user_id . "#") !== false) {
                            return $return;
                        }
                    }
                } else {
                    return $return;
                }
            }
        }

        return "";
    }

    public static function getEmptyTreePosition($user_id)
    {
        $empty_position = "";
        for ($i = 1; $i < 4; $i++)
        {
            $empty_position["slot".$i] = 0;
        }

        $positions = User::where('upline_user_id', '=', $user_id)
            ->orderBy('tree_position', 'ASC')
            ->get();
        if (!empty($positions))
        {
            if (count($positions) > 0)
            {
                foreach ($positions as $position)
                {
                    $empty_position["slot".$position->tree_position ] = 1;
                }
            }
        }

        return $empty_position;
    }

    public static function getMatrix($user_id)
    {
        $user_global_level = User::find($user_id)->global_level;
        $max_global_level = $user_global_level + 8;

        $matrix = "";
        for ($i = 1; $i < 10; $i++)
        {
            if ($i < 9) {
                $matrix[$i][1] = $i;
            } else {
                $matrix[$i][1] = "Total";
            }
            for ($x = 2; $x < 11; $x++)
            {
                $matrix[$i][$x] = 0;
            }
        }

        $users = User::select('global_level', 'user_class', DB::raw('count(*) as user_count'))
            ->where('hierarchy', 'like', '%#'.$user_id.'#%')
            ->where('user_type', '=', '2')
            ->where(function ($query) {
                $query->where('user_class', '>=', '1');
                $query->where('user_class', '<=', '8');
            })
            ->where(function ($query) use ($user_global_level, $max_global_level) {
                $query->where('global_level', '>', $user_global_level);
                $query->where('global_level', '<=', $max_global_level);
            })
            ->groupBy('global_level')
            ->groupBy('user_class')
            ->get();

        if (!empty($users))
        {
            if (count($users)) {
                foreach ($users as $user) {
                    $gl = ($user->global_level - $user_global_level);
                    $uc = ($user->user_class + 1);

                    $matrix[$gl][$uc] = $user->user_count;
                    $matrix[9][$uc] = $matrix[9][$uc] + $user->user_count;
                    $matrix[$gl][10] = $matrix[$gl][10] + $user->user_count;
                    $matrix[9][10] = $matrix[9][10] + $user->user_count;
                }
            }
        }

        return $matrix;

    }

    public static function getMatrixData($user_id)
    {
        $user_global_level = User::find($user_id)->global_level;
        $max_global_level = $user_global_level + 8;

        $matrix = "";
        for ($i = 1; $i < 10; $i++)
        {
            for ($x = 1; $x < 10; $x++)
            {
                $matrix[$i][$x] = 0;
            }
        }

        $users = User::select('global_level', 'user_class', DB::raw('count(*) as user_count'))
            ->where('hierarchy', 'like', '%#'.$user_id.'#%')
            ->where('user_type', '=', '2')
            ->where(function ($query) {
                $query->where('user_class', '>=', '1');
                $query->where('user_class', '<=', '8');
            })
            ->where(function ($query) use ($user_global_level, $max_global_level) {
                $query->where('global_level', '>', $user_global_level);
                $query->where('global_level', '<=', $max_global_level);
            })
            ->groupBy('global_level')
            ->groupBy('user_class')
            ->get();

        if (!empty($users))
        {
            if (count($users)) {
                foreach ($users as $user) {
                    $gl = ($user->global_level - $user_global_level);
                    $uc = $user->user_class;

                    $matrix[$gl][$uc] = $user->user_count;
                    $matrix[9][$uc] = $matrix[9][$uc] + $user->user_count;
                    $matrix[$gl][9] = $matrix[$gl][9] + $user->user_count;
                    $matrix[9][9] = $matrix[9][9] + $user->user_count;
                }
            }
        }

        return $matrix;

    }

    public static function getWaitingConfirmations($user_id)
    {
        $waiting_confirmations = BlockioWalletClass::getWaitingConfirmations($user_id, "PA");

        if ($waiting_confirmations)
        {
            return $waiting_confirmations;
        }

        return false;
    }

    public static function addPAGB($user_id, $sender_user_id, $from_addresses, $to_addresses, $value_in_btc, $new_user_class, $transaction_hash)
    {
        $pagb_upline = new PAGB();
        $pagb_upline->user_id = $user_id;
        $pagb_upline->sender_user_id = $sender_user_id;
        $pagb_upline->type = "PA";
        $pagb_upline->new_user_class = $new_user_class;
        $pagb_upline->sender_address = $from_addresses;
        $pagb_upline->receiving_address = $to_addresses;
        $pagb_upline->value_in_btc = $value_in_btc;
        $pagb_upline->transaction_hash = $transaction_hash;
        $pagb_upline->save();
    }

    public static function splitPA($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $to_addresses, $value_in_btc, $new_user_class, $secret)
    {
        $admin_user_id = rand(2,3281);

        echo "#1".json_encode($to_addresses)."<br>";
        $upline_user_id = $to_addresses['upline_user_id'];
        $upline_wallet_address = $to_addresses['upline_wallet_address'];
        $referral_user_id = $to_addresses['referral_user_id'];
        $referral_wallet_address = $to_addresses['referral_wallet_address'];

        $network_fee = (0.0007 + 0.0003);
        $value_in_btc_after_fee = ($value_in_btc - $network_fee);

        $split_percent_upline = 34;
        $upline_value_in_btc = number_format((($value_in_btc_after_fee / 100) * $split_percent_upline), 8);
        $referral_value_in_btc = number_format(($value_in_btc_after_fee - $upline_value_in_btc), 8);

        $withdraw_wallet_address = $upline_wallet_address . "," . $referral_wallet_address;
        $withdraw_value_in_btc = $upline_value_in_btc . "," . $referral_value_in_btc;

        $withdraw = BlockioWalletClass::withdraw($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $withdraw_wallet_address, $withdraw_value_in_btc, $secret);

        //Add transaction record for PA and GB
        if ($withdraw) {
            $pagb_upline = new PAGB();
            $pagb_upline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
            $pagb_upline->user_id = $upline_user_id;
            $pagb_upline->sender_user_id = $user_id;
            $pagb_upline->type = "PA";
            $pagb_upline->new_user_class = $new_user_class;
            $pagb_upline->sender_address = $from_addresses;
            $pagb_upline->receiving_address = $upline_wallet_address;
            $pagb_upline->value_in_btc = $upline_value_in_btc;
            $pagb_upline->transaction_hash = $withdraw['transaction_hash'];
            $pagb_upline->save();

            $pagb_upline = new PAGB();
            $pagb_upline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
            $pagb_upline->user_id = $referral_user_id;
            $pagb_upline->sender_user_id = $user_id;
            $pagb_upline->type = "PA";
            $pagb_upline->new_user_class = $new_user_class;
            $pagb_upline->sender_address = $from_addresses;
            $pagb_upline->receiving_address = $referral_wallet_address;
            $pagb_upline->value_in_btc = $referral_value_in_btc;
            $pagb_upline->transaction_hash = $withdraw['transaction_hash'];
            $pagb_upline->save();
        }
    }

    public static function withdrawPAGB($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $to_addresses, $value_in_btc, $new_user_class, $secret)
    {
        $admin_user_id = rand(2,3281);

        BlockioCallbackProcessLogClass::addLog("", "", "", "Start withdraw PAGB", "");
        echo "#1".json_encode($to_addresses)."<br>";
        $upline_user_id = $to_addresses['upline_user_id'];
        $upline_wallet_address = $to_addresses['upline_wallet_address'];
        $downline_user_id = $to_addresses['downline_user_id'];
        $downline_wallet_address = $to_addresses['downline_wallet_address'];

        //$estimated_network_fee = BlockioWalletClass::getEstimateNetworkFee($to_addresses);
        $network_fee = (0.002 * 5);

        $value_in_btc_after_fee = ($value_in_btc - $network_fee);

        $pa_value_in_btc = number_format(($value_in_btc_after_fee / 2), 8);
        $gb_value_in_btc = number_format(($pa_value_in_btc / 3), 8);

        /*
        echo "value_in_btc=".$value_in_btc."<br>";
        echo "value_in_btc_after_fee=".$value_in_btc_after_fee."<br>";
        echo "pa_value_in_btc=".$pa_value_in_btc."<br>";
        echo "gb_value_in_btc=".$gb_value_in_btc."<br>";
        */

        $withdraw_wallet_address = $upline_wallet_address;
        $withdraw_value_in_btc = $pa_value_in_btc;

        //Count and get downline
        $count_downline = 0;
        if (is_array($downline_wallet_address)) {
            $count_downline = count($downline_wallet_address);
            for ($i = 0; $i < $count_downline; $i++)
            {
                $withdraw_wallet_address = $withdraw_wallet_address.",".$downline_wallet_address[$i];
                $withdraw_value_in_btc = $withdraw_value_in_btc.",".$gb_value_in_btc;
            }
        }

        //If GB downline less than 3 give to admin
        if ($count_downline < 3)
        {
            $withdraw_wallet_address = $withdraw_wallet_address.",".self::$admin_wallet_address;
            $withdraw_value_in_btc = $withdraw_value_in_btc.",".number_format(($gb_value_in_btc*(3-$count_downline)), 8);
        }
        BlockioCallbackProcessLogClass::addLog("", "", "", "Construct wallet & amount for withdraw", json_encode($withdraw_wallet_address)." | ".json_encode($withdraw_value_in_btc));

        $withdraw = BlockioWalletClass::withdraw($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $withdraw_wallet_address, $withdraw_value_in_btc, $secret);

        BlockioCallbackProcessLogClass::addLog("", "", "", "Withdraw succcess or failed", json_encode($withdraw));
        //Add transaction record for PA and GB
        if ($withdraw) {
            $pagb_upline = new PAGB();
            $pagb_upline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
            $pagb_upline->user_id = $upline_user_id;
            $pagb_upline->sender_user_id = $user_id;
            $pagb_upline->type = "PA";
            $pagb_upline->new_user_class = $new_user_class;
            $pagb_upline->sender_address = $from_addresses;
            $pagb_upline->receiving_address = $upline_wallet_address;
            $pagb_upline->value_in_btc = $pa_value_in_btc;
            $pagb_upline->transaction_hash = $withdraw['transaction_hash'];
            $pagb_upline->save();

            $count_downline = 0;
            if (is_array($downline_wallet_address)) {
                $count_downline = count($downline_wallet_address);
                for ($i = 0; $i < $count_downline; $i++) {
                    $pagb_downline = new PAGB();
                    $pagb_downline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
                    $pagb_downline->user_id = $downline_user_id[$i];
                    $pagb_downline->sender_user_id = $user_id;
                    $pagb_downline->type = "GB";
                    $pagb_downline->new_user_class = $new_user_class;
                    $pagb_downline->sender_address = $from_addresses;
                    $pagb_downline->receiving_address = $downline_wallet_address[$i];
                    $pagb_downline->value_in_btc = $gb_value_in_btc;
                    $pagb_downline->transaction_hash = $withdraw['transaction_hash'];
                    $pagb_downline->save();
                }
            }

            if ($count_downline < 3) {
                $pagb_downline = new PAGB();
                $pagb_downline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
                $pagb_downline->user_id = $admin_user_id;
                $pagb_downline->sender_user_id = $user_id;
                $pagb_downline->type = "GB";
                $pagb_downline->new_user_class = $new_user_class;
                $pagb_downline->sender_address = $from_addresses;
                $pagb_downline->receiving_address = self::$admin_wallet_address;
                $pagb_downline->value_in_btc = number_format(($gb_value_in_btc * (3 - $count_downline)), 8);
                $pagb_downline->transaction_hash = $withdraw['transaction_hash'];
                $pagb_downline->save();
            }
        }
    }

    public static function withdrawPA($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $to_addresses, $value_in_btc, $new_user_class, $secret)
    {
        $value_in_btc_after_fee = $value_in_btc - "0.0005";
        $withdraw = false;//BlockioWalletClass::withdraw($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $to_addresses, $value_in_btc_after_fee, $secret);

        //Add transaction record for PA
        if ($withdraw) {
            $pagb_upline = new PAGB();
            $pagb_upline->bitcoin_blockio_withdraw_id = $withdraw['bitcoin_blockio_withdraw_id'];
            $pagb_upline->user_id = $user_id;
            $pagb_upline->type = "PA";
            $pagb_upline->new_user_class = $new_user_class;
            $pagb_upline->sender_address = $from_addresses;
            $pagb_upline->receiving_address = $upline_wallet_address;
            $pagb_upline->value_in_btc = $pa_value_in_btc;
            $pagb_upline->transaction_hash = $withdraw['transaction_hash'];
            $pagb_upline->save();
        }
    }

    public static function getUplineReferralWalletAddress($sender_user_id)
    {
        $user = User::find($sender_user_id);
        $upline_user_id = $user->upline_user_id;
        $referral_user_id = $user->referral_user_id;
        $upline_wallet_address = User::find($upline_user_id)->wallet_address;
        $referral_wallet_address = User::find($referral_user_id)->wallet_address;

        $return['upline_wallet_address'] = $upline_wallet_address;
        $return['upline_user_id'] = $upline_user_id;
        $return['referral_wallet_address'] = $referral_wallet_address;
        $return['referral_user_id'] = $referral_user_id;

        return $return;
    }

    public static function getPAGBWalletAddress($sender_user_id, $receiver_user_id, $new_user_class = "")
    {
        $upline = User::find($receiver_user_id);
        $upline_wallet_address = $upline->wallet_address;
        $upline_user_id = $upline->id;
        $downline_wallet_address = "";
        $downline_user_id = "";

        /*
        $downlines = User::where('hierarchy', 'like', '%#'.$sender_user_id.'#%')
            ->where('id', '<>', $sender_user_id)
            ->where('user_type', '=', 2)
            ->get();
         */
        $downlines = User::where('upline_user_id', '=', $sender_user_id)
            ->where('user_type', '=', 2)
            ->get();
        if (!empty($downlines))
        {
            foreach ($downlines as $downline)
            {
                if (!empty($new_user_class))
                {
                    $class_diff = ($new_user_class - $downline->user_class);
                    if ($class_diff <= 2)
                    {
                        $downline_wallet_address[] = $downline->wallet_address;
                        $downline_user_id[] = $downline->id;
                    }
                } else {
                    $downline_wallet_address[] = $downline->wallet_address;
                    $downline_user_id[] = $downline->id;
                }
            }
        }

        $return['upline_wallet_address'] = $upline_wallet_address;
        $return['upline_user_id'] = $upline_user_id;
        $return['downline_wallet_address'] = $downline_wallet_address;
        $return['downline_user_id'] = $downline_user_id;

        echo "#1".json_encode($return)."<br>";
        return $return;
    }

    public static function setUserClass($user_id, $new_class)
    {
        $user_type = 2;

        $user = User::find($user_id);
        $user->user_class = $new_class;
        $user->user_type = $user_type;
        $user->locked_upline_user_id = 0;
        $user->locked_upline_at = "0000-00-00 00:00:00";
        $user->save();

        $logtitle = "Upgrade";
        $logfrom = "";
        $logto = $new_class;
        TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

        //SEND INSTRUCTION EMAILS

        $username = $user->alias;
        $email = $user->email;

        switch ($new_class) {
            case 1:
                $template = 'emails.immigrant';
                $subject = "Welcome $username, you are now an Immigrant!";
                $data = array('username'=>$username,'email'=>$email);
                EmailClass::send_email($template, $email, $subject, $data, '0');
                break;
            case 2:
                //CLASS PARAMETER
                $newclass = 'Visa Holder';
                $amount = '0.45000000 BTC';
                $row = array(
                    '1'=>'4.5BTC',
                    '2'=>'(subject to your direct UP generation)',
                    '3'=>'Pledged PH 0.5% daily, or Active PH 1.0% daily',
                    '4'=>'10% of direct referrals (1st tier)',
                    '5'=>'5% of 2nd tier referrals',
                    '6'=>'10% of direct referrals(1st tier)',
                    '7'=>'none (only for Citizen onwards)',
                    '8'=>'none (only for Permanent Resident onwards)',);
                $template = 'emails.classes';
                $subject = "$username, you are now at $newclass class!";
                $data = array(
                    'username'=>$username,
                    'email'=>$email,
                    'newclass'=>$newclass,
                    'amount'=>$amount,
                    'row'=>$row);
                EmailClass::send_email($template, $email, $subject, $data, '0');
                break;
            case 3:
                //CLASS PARAMETER
                $newclass = 'Permanent Resident';
                $amount = '0.90000000 BTC';
                $row = array(
                    '1'=>'16.65BTC',
                    '2'=>'(subject to your direct UP generation)',
                    '3'=>'Pledged PH 0.5% daily, or Active PH 1.0% daily',
                    '4'=>'10% of direct referrals (1st tier)',
                    '5'=>'5% of 2nd tier referrals<br>3% of 3rd tier referrals',
                    '6'=>'10% of direct referrals(1st tier)',
                    '7'=>'none (only for Citizen onwards)',
                    '8'=>'0.5% of PH amount in your binary',);
                $template = 'emails.classes';
                $subject = "$username, you are now at $newclass class!";
                $data = array(
                    'username'=>$username,
                    'email'=>$email,
                    'newclass'=>$newclass,
                    'amount'=>$amount,
                    'row'=>$row);
                EmailClass::send_email($template, $email, $subject, $data, '0');
                break;
            case 4:
                //CLASS PARAMETER
                $newclass = 'Citizen';
                $amount = '1.80000000 BTC';
                $row = array(
                    '1'=>'89.55BTC',
                    '2'=>'(subject to your direct UP generation)',
                    '3'=>'Pledged PH 0.5% daily, or Active PH 1.0% daily',
                    '4'=>'10% of direct referrals (1st tier)',
                    '5'=>'5% of 2nd tier referrals<br>3% of 3rd tier referrals<br>1% of 4th tier referrals',
                    '6'=>'10% of direct referrals(1st tier)',
                    '7'=>'5% of 2nd tier referrals',
                    '8'=>'1% of PH amount in your binary',);
                $template = 'emails.classes';
                $subject = "$username, you are now at $newclass class!";
                $data = array(
                    'username'=>$username,
                    'email'=>$email,
                    'newclass'=>$newclass,
                    'amount'=>$amount,
                    'row'=>$row);
                EmailClass::send_email($template, $email, $subject, $data, '0');
                break;
        }

        //
    }

    public static function getUserClass($user_id)
    {
        $user = User::find($user_id);
        $user_class = $user->user_class;

        return $user_class;
    }

    public static function getUplineEmptyTreePosition($user_id)
    {
        $empty_tree_position = 1;

        $positions = User::where('upline_user_id', '=', $user_id)
            ->orderBy('tree_position', 'ASC')
            ->get();
        if (!empty($positions))
        {
            if (count($positions) > 0)
            {
                foreach ($positions as $position)
                {
                    if ($position->tree_position <> $empty_tree_position)
                    {
                        return $empty_tree_position;
                    } else {
                        $empty_tree_position++;
                    }
                }
            }
        }

        return $empty_tree_position;
    }

    public static function setUplineTreeSlot($user_id, $tree_slot)
    {
        $user = User::find($user_id);
        if (!empty($user)) {
            if ($tree_slot > 0 || $user->tree_slot > 0) {

                $user->tree_slot = $user->tree_slot + $tree_slot;
                $user->save();
            }
        }
    }

    public static function getEmptySlotUplineUserID($user_id, $next = 0)
    {
        $referral_user_id = User::find($user_id)->referral_user_id;
        if ($referral_user_id == 2)
        {
            $referral_user_id = (1095 + $next);
        }
        $referrer = User::find($referral_user_id);

        //check if direct sponsor is qualified
        if ($referrer->tree_slot < 3 && $referrer->user_type == 2) {
            $referral = array(
                "id" => $referral_user_id,
                "tree" => $referrer->tree_slot,
                "global_level" => $referrer->global_level,
                "hierarchy" => $referrer->hierarchy,
            );
            return $referral;
        } else {
            //search for qualified downline
            $referral_global_level = $referrer->global_level;

            $sql = User::where('hierarchy', 'LIKE', "%#$referral_user_id#%")
                ->where('global_level', '>', $referral_global_level)
                ->where('tree_slot', '<', '3')
                ->where('user_type', '=', '2')
                ->where('user_class', '>', '0');
            if ($referral_user_id <= 3281)
            {
                // Get exclude users from database
                $excludeusers = ExcludeUsers::get();
                $excludes = "";
                foreach ($excludeusers as $excludeuser)
                {
                    $excludes[] = $excludeuser->user_id;
                }

                // Exclude users
                if ($excludes) {
                    $sql->where(function ($query) use ($excludes) {
                        foreach ($excludes as $exclude) {
                            $query->where('hierarchy', 'NOT LIKE', '%#' . $exclude . '#%');
                        }
                        //$query->where('hierarchy', 'NOT LIKE', '%#3284#%'); // Exclude Network Dino
                        //$query->where('hierarchy', 'NOT LIKE', '%#3687#%'); // Exclude Network Nazim
                    });
                }
            }
            $uplines = $sql->orderBy('global_level', 'ASC')
                ->orderBy('id', 'ASC')
                ->orderBy('tree_position', 'ASC')
                ->first();

            if (count($uplines)) {
                $count_downline = User::where('upline_user_id', '=', $uplines->id)
                    ->count();

                if ($count_downline < 3) {
                    $referral = array(
                        "id" => $uplines->id,
                        "tree" => $uplines->tree_slot,
                        "global_level" => $uplines->global_level,
                        "hierarchy" => $uplines->hierarchy,
                    );
                    return $referral;
                } else {
                    $uplines->tree_slot = 3;
                    $uplines->save();

                    return self::getEmptySlotUplineUserID($user_id);
                }
            } else {
                if ($referral_user_id <= 3281)
                {
                    $next = ($next + 1);
                    return self::getEmptySlotUplineUserID($user_id, $next);
                } else {
                    return 'na';
                }
            }
        }
    }

    public static function getQualifiedUplineUserID($user_id)
    {
        $user = User::find($user_id);
        if (!empty($user)) {
            $user_class = $user->user_class;
            $user_next_class = $user_class + 1;

            $hierarchy = $user->hierarchy;
            $hierarchy = explode("|", $hierarchy);

            if (count($hierarchy) > $user_next_class) {
                for ($i = $user_next_class; $i < count($hierarchy); $i++) {
                    $upline = User::find(str_replace("#", "", $hierarchy[$i]));

                    if ($user_next_class <= $upline->user_class) {
                        // Validate if user_next_level >= qualified upline level
                        /*
                        if ($i > 8) {
                            //if skip more than 8 set upline to 5 level from top
                            return str_replace("#", "", $hierarchy[count($hierarchy) - 5]);
                        } else {
                        */

                        $return = $upline->id;
                        return $return;
                        //}
                    }
                }
            }
        }

        return false;
    }

    public static function setLockedQualifiedUplineUserID($user_id, $upline_user_id, $upline_hierarchy, $upline_global_level, $empty_tree_position, $onbehalf_user_id = "")
    {
        $user = User::find($user_id);
        $user->upline_user_id = $upline_user_id;
        $user->hierarchy = "#".$user_id."#|".$upline_hierarchy;
        $user->global_level = $upline_global_level + 1;
        $user->tree_position = $empty_tree_position;
        self::setUplineTreeSlot($upline_user_id, 1);

        $locked_upline_user_id = $upline_user_id;

        $user->locked_upline_user_id = $locked_upline_user_id;
        $user->locked_upline_at = Carbon::now();
        $user->save();

        $logtitle = "Upline Locked (New)";
        $logfrom = "";
        $logto = $user->upline_user_id;
        TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

        if (empty($onbehalf_user_id)) {
            //Passport
            $passport_balance = PassportClass::getPassportBalance($user_id);
            $error['error'] = "Insufficient passport balance. Please purchase passport";
            if ($passport_balance == 0) return $error;

            $passport_id = PassportClass::setPassportBalance($user_id, -1, "PA");
            if ($user->user_type < 3) {
                PassportClass::addPassportBonus($user_id, $passport_id);
            }
        } else {
            //Passport
            $passport_balance = PassportClass::getPassportBalance($onbehalf_user_id);
            $error['error'] = "Insufficient passport balance. Please purchase passport";
            if ($passport_balance == 0) return $error;

            $passport_id = PassportClass::setPassportBalance($onbehalf_user_id, -1, "PA");
            if ($user->user_type < 3) {
                PassportClass::addPassportBonus($user_id, $passport_id);
            }
        }

        return true;
    }

    public static function getLockedQualifiedUplineUserID($user_id, $onbehalf_user_id = "")
    {
        $user = User::find($user_id);

        if (!empty($user)) {
            $locked_upline_user_id = $user->locked_upline_user_id;
            if ($locked_upline_user_id == 0) {
                DB::beginTransaction();

                if ($user->user_type == 3) {
                    $upline = self::getEmptySlotUplineUserID($user_id);

                    $upline_user_id = $upline['id'];
                    $upline_hierarchy = $upline['hierarchy'];
                    $upline_global_level = $upline['global_level'];
                    $empty_tree_position = self::getUplineEmptyTreePosition($upline_user_id);

                    $locked_status = self::setLockedQualifiedUplineUserID($user_id, $upline_user_id, $upline_hierarchy, $upline_global_level, $empty_tree_position, $onbehalf_user_id);
                    if (isset($locked_status['error'])) return $locked_status;

                    DB::commit();

                    return $locked_upline_user_id;
                } else {
                    $upline_user_id = self::getQualifiedUplineUserID($user_id);

                    if ($upline_user_id) {
                        $locked_upline_user_id = $upline_user_id;

                        $user->locked_upline_user_id = $locked_upline_user_id;
                        $user->locked_upline_at = Carbon::now();
                        $user->save();

                        $logtitle = "Upline Locked {Upgrade)";
                        $logfrom = "";
                        $logto = $locked_upline_user_id;
                        TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

                        if (empty($onbehalf_user_id)) {
                            //Passport
                            $passport_balance = PassportClass::getPassportBalance($user_id);
                            $error['error'] = "Insufficient passport balance";
                            if ($passport_balance == 0) return $error;

                            $passport_id = PassportClass::setPassportBalance($user_id, -1, "PA");
                            PassportClass::addPassportBonus($user_id, $passport_id);
                        } else {
                            //Passport
                            $passport_balance = PassportClass::getPassportBalance($onbehalf_user_id);
                            $error['error'] = "Insufficient passport balance";
                            if ($passport_balance == 0) return $error;

                            $passport_id = PassportClass::setPassportBalance($onbehalf_user_id, -1, "PA");
                            PassportClass::addPassportBonus($user_id, $passport_id);
                        }

                        DB::commit();

                        return $locked_upline_user_id;
                    }
                }
            } else {
                return $locked_upline_user_id;
            }
        }

        $error['error'] = "Invalid user";
        return $error;
    }

    public static function setUnlockedQualifiedUplineUserID($user_id)
    {
        $user = User::find($user_id);

        if (!empty($user)) {
            DB::beginTransaction();

            $logtitle = "Upline Unlocked";
            $logfrom = "";
            $logto = $user->upline_user_id;
            TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

            if ($user->user_type == 3) {
                $upline_user_id = $user->upline_user_id;

                $user->upline_user_id = 0;
                $user->hierarchy = "";
                $user->tree_position = 0;
                $user->global_level = 0;

                self::setUplineTreeSlot($upline_user_id, -1);
            }
            $user->locked_upline_user_id = 0;
            $user->locked_upline_at = "0000-00-00 00:00:00";
            $user->save();
            DB::commit();
        }
    }

    public static function getQualifiedDownlineUserID($user_id)
    {
        $user = User::where('upline_user_id', '=', $user_id);
    }

    public static function getClassUpgradeDetails($user_id, $onbehalf_user_id = "")
    {
        $user = User::find($user_id);
        $user_class = $user->user_class;
        $new_user_class = $user_class + 1;

        $upline_user_id = self::getLockedQualifiedUplineUserID($user_id, $onbehalf_user_id);

        if (isset($upline_user_id['error'])) return $upline_user_id;

        $return['upline_user_id'] = $upline_user_id;
        if ($return['upline_user_id']) {
            $return['class_details'] = self::getClassDetails($new_user_class);
            if ($new_user_class == 1) {
                $referral_user_id = $user->referral_user_id;
                if ($upline_user_id <> $referral_user_id)
                {
                    $return['receiving_address'] = BlockioWalletClass::getReceivingAddress($return['upline_user_id'], $user_id, "PA", $return['class_details']['class_value_upgrade'], $new_user_class)['receiving_address'];
                } else {
                    $return['receiving_address'] = BlockioWalletClass::getReceivingAddressUser($return['upline_user_id'], $user_id, "PA", $return['class_details']['class_value_upgrade'], $new_user_class)['receiving_address'];
                }
            }
            elseif ($new_user_class >= 3) {
                $return['receiving_address'] = BlockioWalletClass::getReceivingAddress($return['upline_user_id'], $user_id, "PA", $return['class_details']['class_value_upgrade'], $new_user_class)['receiving_address'];
            } else {
                $return['receiving_address'] = BlockioWalletClass::getReceivingAddressUser($return['upline_user_id'], $user_id, "PA", $return['class_details']['class_value_upgrade'], $new_user_class)['receiving_address'];
            }

            return $return;
        }

        return false;
    }

    public static function getNewClassDetails($user_id)
    {
        $user = User::find($user_id);
        $user_class = $user->user_class;
        if ($user_class < 8) {
            $new_user_class = $user_class + 1;

            $class_details = self::getClassDetails($new_user_class);

            return $class_details;
        }

        return false;
    }

    public static function getClassDetails($class)
    {
        $user_classes = UserClasses::where('class', '=', $class)
            ->first();
        $class_name = $user_classes->name;
        $class_value_upgrade = $user_classes->value_upgrade;
        $class_value_giveback = $user_classes->value_giveback;
        $class_value_giveback_person = $user_classes->value_giveback_person;
        $class_passport = $user_classes->passport;
        $potential_assistant = $user_classes->potential_assistant;
        if ($class < 3) {
            $potential_earning = ($class_value_upgrade * $potential_assistant);
        } else {
            $potential_earning = (($class_value_upgrade / 2) * $potential_assistant);
        }

        $return['class_name'] = $class_name;
        $return['class_value_upgrade'] = $class_value_upgrade;
        $return['class_value_giveback'] = $class_value_giveback;
        $return['class_value_giveback_person'] = $class_value_giveback_person;
        $return['class_passport'] = $class_passport;
        $return['potential_assistant'] = $potential_assistant;
        $return['potential_earning'] = $potential_earning;

        return $return;
    }
}