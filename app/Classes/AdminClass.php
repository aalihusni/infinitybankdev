<?php
namespace App\Classes;

use App\BitcoinBlockioWalletReceiving;
use App\CronLog;
use App\BankPH;
use App\BankGH;
use App\BankPHGH;
use App\BankPair;
use App\Settings;
use App\Shares;
use App\TrailLog;
use App\Classes\SharesClass;
use App\Classes\BitcoinWalletClass;
use App\User;
use DB;
use Carbon\Carbon;

class AdminClass
{
    public static function addCronLog($desc)
    {
        $sys_status = env('SYS_STATUS', 0);
        $cronlog = new CronLog();
        $cronlog->description = $desc;
        $cronlog->type = $sys_status;
        $cronlog->save();
    }

    public static function test()
    {
        $excel = App::make('excel');
    }

    public static function checkPH()
    {
        echo "##PH##<br>";
        $bank_ph = BankPH::where('ph_type','=','0')
            ->where(function ($query) {
                $query->where('status', '=', 1);
                $query->orwhere('status', '=', 2);
            })
            ->get();

        if (!empty($bank_ph))
        {
            if (count($bank_ph) > 0)
            {
                foreach ($bank_ph as $ph)
                {
                    DB::beginTransaction();

                    $bank_phgh = BankPHGH::where('ph_id','=',$ph->id)
                        ->where('status', '<>', 3)
                        ->orderby('id','asc')
                        ->get();

                    $count_ph_value = 0;

                    if (!empty($bank_phgh))
                    {
                        if (count($bank_phgh) > 0)
                        {
                            foreach ($bank_phgh as $phgh)
                            {
                                $count_ph_value = $count_ph_value + $phgh->value_in_btc;
                            }
                        }
                    }

                    if (number_format($count_ph_value,8) > $ph->value_in_btc)
                    {
                        echo "##".$ph->id." | ".$ph->user_id." | ".$ph->value_in_btc." | ".$count_ph_value."<br>";

                        $count_duplicate = 0;
                        $duplicate = 0;
                        foreach ($bank_phgh as $phgh)
                        {
                            echo $phgh->id . " | " . $phgh->ph_id . " | " . $phgh->ph_user_id . " | " . $phgh->value_in_btc . " | " . $phgh->gh_user_id . " | " . $phgh->gh_id . " | " . $phgh->status . "<br>";
                            if ($duplicate == 0)
                            {
                                if ($count_duplicate + $phgh->value_in_btc > $ph->value_in_btc)
                                {
                                    $duplicate = 1;
                                } else {
                                    $count_duplicate = $count_duplicate + $phgh->value_in_btc;
                                }
                            }

                            if ($duplicate == 1)
                            {
                                $phgh->status = 3;
                                $phgh->save();

                                echo "Duplicate<br>";
                            }
                        }
                        if ($duplicate == 1)
                        {
                            if ($count_duplicate >= $ph->value_in_btc)
                            {
                                $ph->status = 2;
                                $ph->save();
                            } else {
                                $ph->status = 1;
                                $ph->save();
                            }
                        }
                        echo "##<br>";
                    }

                    DB::commit();
                    //DB::rollback();
                }
            }
        }
    }

    public static function checkGH()
    {
        echo "##GH##<br>";
        $bank_gh = BankGH::where(function ($query) {
                $query->where('status', '=', 1);
                $query->orwhere('status', '=', 2);
            })
            ->get();

        if (!empty($bank_gh))
        {
            if (count($bank_gh) > 0)
            {
                foreach ($bank_gh as $gh)
                {
                    DB::beginTransaction();

                    $bank_phgh = BankPHGH::where('gh_id','=',$gh->id)
                        ->where('status', '<>', 3)
                        ->orderby('id','asc')
                        ->get();

                    $count_gh_value = 0;

                    if (!empty($bank_phgh))
                    {
                        if (count($bank_phgh) > 0)
                        {
                            foreach ($bank_phgh as $phgh)
                            {
                                $count_gh_value = $count_gh_value + $phgh->value_in_btc;
                            }
                        }
                    }

                    if (number_format($count_gh_value,8) > $gh->value_in_btc)
                    {
                        echo "##".$gh->id." | ".$gh->user_id." | ".$gh->value_in_btc." | ".$count_ph_value."<br>";

                        $count_duplicate = 0;
                        $duplicate = 0;
                        foreach ($bank_phgh as $phgh)
                        {
                            echo $phgh->id . " | " . $phgh->ph_id . " | " . $phgh->ph_user_id . " | " . $phgh->value_in_btc . " | " . $phgh->gh_user_id . " | " . $phgh->gh_id . " | " . $phgh->status . "<br>";
                            if ($duplicate == 0)
                            {
                                if ($count_duplicate + $phgh->value_in_btc > $gh->value_in_btc)
                                {
                                    $duplicate = 1;
                                } else {
                                    $count_duplicate = $count_duplicate + $phgh->value_in_btc;
                                }
                            }

                            if ($duplicate == 1)
                            {
                                $phgh->status = 3;
                                $phgh->save();

                                echo "Duplicate<br>";
                            }
                        }
                        if ($duplicate == 1)
                        {
                            if ($count_duplicate >= $gh->value_in_btc)
                            {
                                $gh->status = 2;
                                $gh->save();
                            } else {
                                $gh->status = 1;
                                $gh->save();
                            }
                        }
                        echo "##<br>";
                    }

                    //DB::commit();
                    DB::rollback();
                }
            }
        }
    }

    public static function countPH()
    {
        echo "##PH##<br>";
        $bank_ph = BankPH::where('ph_type','=','0')
            ->where(function ($query) {
                $query->where('status', '=', 1);
                $query->orwhere('status', '=', 2);
            })
            ->get();

        if (!empty($bank_ph))
        {
            if (count($bank_ph) > 0)
            {
                foreach ($bank_ph as $ph)
                {
                    DB::beginTransaction();

                    $bank_phgh = BankPHGH::where('ph_id','=',$ph->id)
                        ->where('status', '<>', 3)
                        ->orderby('id','asc')
                        ->get();

                    $count_ph_value = 0;

                    if (!empty($bank_phgh))
                    {
                        if (count($bank_phgh) > 0)
                        {
                            foreach ($bank_phgh as $phgh)
                            {
                                $count_ph_value = $count_ph_value + $phgh->value_in_btc;
                            }
                        }
                    }

                    if ($count_ph_value >= $ph->value_in_btc)
                    {
                        if ($ph->status <> 2) echo $ph->status." | 2<br>";
                        $ph->status = 2;
                        $ph->save();
                    } else {
                        if ($ph->status <> 1) echo $ph->status." | 1<br>";
                        $ph->status = 1;
                        $ph->save();
                    }
                    echo "##<br>";

                    DB::commit();
                    //DB::rollback();
                }
            }
        }
    }

    public static function countGH()
    {
        echo "##GH##<br>";
        $bank_gh = BankGH::where(function ($query) {
            $query->where('status', '=', 1);
            $query->orwhere('status', '=', 2);
        })
            ->get();

        if (!empty($bank_gh))
        {
            if (count($bank_gh) > 0)
            {
                foreach ($bank_gh as $gh)
                {
                    DB::beginTransaction();

                    $bank_phgh = BankPHGH::where('gh_id','=',$gh->id)
                        ->where('status', '<>', 3)
                        ->orderby('id','asc')
                        ->get();

                    $count_gh_value = 0;

                    if (!empty($bank_phgh))
                    {
                        if (count($bank_phgh) > 0)
                        {
                            foreach ($bank_phgh as $phgh)
                            {
                                $count_gh_value = $count_gh_value + $phgh->value_in_btc;
                            }
                        }
                    }

                    if ($count_gh_value >= $gh->value_in_btc)
                    {
                        if ($gh->status <> 2) echo $gh->status." | 2<br>";
                        $gh->status = 2;
                        $gh->save();
                    } else {
                        if ($gh->status <> 1) echo $gh->status." | 1<br>";
                        $gh->status = 1;
                        $gh->save();
                    }
                    echo "##<br>";

                    DB::commit();
                    //DB::rollback();
                }
            }
        }
    }

    public static function fixDuplicateActivePH()
    {
        $duplicate_list = BankPH::select(DB::raw('count(id) as xcount'),'bank_ph.link_ph_id','bank_ph.value_in_btc')
            ->where('link_ph_id','<>','0')
            ->where('ph_type','=','1')
            ->groupby('link_ph_id')
            ->groupby('value_in_btc')
            ->orderby('xcount','desc')
            ->get();

        if (!empty($duplicate_list))
        {
            if (count($duplicate_list) > 0)
            {
                foreach ($duplicate_list as $list)
                {
                    if ($list->xcount > 1)
                    {
                        $duplicate_ph = BankPH::where('link_ph_id', '=', $list->link_ph_id)
                            ->where('value_in_btc', '=', $list->value_in_btc)
                            ->get();

                        if (!empty($duplicate_ph))
                        {
                            if (count($duplicate_ph) > 0)
                            {
                                $i = 0;
                                DB::beginTransaction();
                                foreach ($duplicate_ph as $ph)
                                {
                                    $i++;
                                    if ($i > 1)
                                    {
                                        echo $i . " | " . $ph->user_id . " | " . $ph->value_in_btc . " | " . $ph->status . "<br>";

                                        $id_length = strlen($ph->user_id);
                                        $id_add = "";
                                        for ($x = 0; $x <= (8 - $id_length); $x++) {
                                            $id_add = $id_add."9";
                                        }
                                        $ph->user_id = $id_add . $ph->user_id;

                                        $id_length = strlen($ph->link_ph_id);
                                        $id_add = "";
                                        for ($x = 0; $x <= (8 - $id_length); $x++) {
                                            $id_add = $id_add."9";
                                        }
                                        $ph->link_ph_id = $id_add . $ph->link_ph_id;

                                        $ph->status = 6;
                                        $ph->save();
                                    }
                                }
                                DB::commit();
                                //DB::rollback();
                            }
                        }
                    }
                }
            }
        }
    }

    public static function fixDuplicateActivePHID()
    {
        $duplicate_list = BankPH::where('user_id','like','123%')
            ->get();

        if (!empty($duplicate_list))
        {
            if (count($duplicate_list) > 0)
            {
                foreach ($duplicate_list as $list)
                {
                    DB::beginTransaction();
                    if (strlen($list->link_ph_id) == 8)
                    {
                        $temp1 = substr($list->link_ph_id,0,3);
                        $temp2 = substr($list->link_ph_id,3);
                        echo $list->link_ph_id . " | " . $temp1 . " | " . $temp2 . "<br>";
                        $list->link_ph_id = "999".$temp2;
                        $list->save();
                    }

                    if (strlen($list->user_id) == 8)
                    {
                        $temp1 = substr($list->user_id,0,3);
                        $temp2 = substr($list->user_id,3);
                        echo $list->user_id . " | " . $temp1 . " | " . $temp2 . "<br>";
                        $list->user_id = "999".$temp2;
                        $list->save();
                    }
                    DB::commit();
                }
            }
        }
    }

    public static function pairReversal($year, $month)
    {
        $pairing = BankPair::where('year','=',$year)
            ->where('month','=',$month)
            ->get();

        if (!empty($pairing))
        {
            if (count($pairing) > 0)
            {
                foreach ($pairing as $pair)
                {
                    DB::beginTransaction();

                    $user_id = $pair->user_id;
                    $shares_type = "FP-REVERSAL";
                    $shares_type_id = $pair->id;
                    $shares_type_user_id = $pair->user_id;
                    $shares_type_percent = $pair->bonus_percent;
                    $value_in_btc = (-1 * abs($pair->bonus_amount));
                    $secret = BitcoinWalletClass::generateSecret();

                    if ($pair->bonus_amount > 0)
                    {
                        echo Carbon::now() . " : " . $pair->user_id . " | " . $pair->bonus_percent . " | " . $pair->bonus_amount . "<br>\r\n";
                        SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $shares_type_user_id, $shares_type_percent, $value_in_btc);
                    }

                    $id_length = strlen($pair->user_id);
                    $id_add = "";
                    for ($x = 0; $x <= (8 - $id_length); $x++) {
                        $id_add = $id_add."9";
                    }
                    $pair->user_id = $id_add . $pair->user_id;
                    $pair->save();

                    DB::commit();
                }
            }
        }
    }

    public static function pairUndoReversal($year, $month)
    {
        $pairing = BankPair::where('year', '=', $year)
            ->where('month', '=', $month)
            ->get();

        if (!empty($pairing))
        {
            if (count($pairing) > 0)
            {
                echo Carbon::now() . " : ## Undo<br>\r\n";
                foreach ($pairing as $pair)
                {
                    DB::beginTransaction();
                    $undo = Shares::where('shares_type', '=',  'FP')
                        ->where('shares_type_id', '=',  $pair->id)
                        ->first();

                    if (!empty($undo))
                    {
                        if (count($undo) > 0)
                        {
                            echo Carbon::now() . " : " . $pair->user_id . " | " . $pair->bonus_percent . " | " . $pair->bonus_amount . "<br>\r\n";
                            $pair->user_id = $undo->user_id;
                            $pair->save();
                        }
                    }

                    DB::commit();
                }
            }
        }
    }

    public static function checkGHSkipIgnore()
    {
        $gh_list = BankGH::where('skip_ignore', '=', '1')
            ->get();

        if (!empty($gh_list))
        {
            if (count($gh_list) > 0)
            {
                foreach ($gh_list as $gh)
                {
                    $shares_balance = SharesClass::getSharesBalance($gh->user_id)['shares_balance'];

                    if ($shares_balance >= 0)
                    {
                        $gh->skip_ignore = 0;
                        $gh->save();
                    }
                }
            }
        }
    }

    public static function checkLastCron($type = "")
    {
        $sql = CronLog::orderby('id','desc');
        if (!empty($type))
        {
            $sql->where('type','=',$type);
        }
        $cron_log = $sql->first();

        $now = Carbon::now();
        $cron = $cron_log->created_at;
        $diff = $now->diffInHours($cron);

        if ($diff >= 2)
        {
            return $diff;
        } else {
            return false;
        }
    }

    public static function checkLastFullCron($type = "")
    {
        if ($type == 2)
        {
            $sql = CronLog::where('description','like','#2%');
        } else {
            $sql = CronLog::where('description','like','#11%');
        }

        if (!empty($type))
        {
            $sql->where('type','=',$type);
        }
        $cron_log = $sql->orderby('id','desc')->first();

        $now = Carbon::now();
        $cron = $cron_log->created_at;
        $diff = $now->diffInHours($cron);

        if ($diff >= 2)
        {
            return $diff;
        } else {
            return false;
        }
    }

    public static function listCron($type = "")
    {
        $sql = CronLog::orderby('id','desc');
        if (!empty($type))
        {
            $sql->where('type','=',$type);
        }
        $cron_log = $sql->take(40)->get();
        return $cron_log;
        /*
        foreach ($cron_log->reverse() as $log)
        {
            echo $log->created_at . " | " . $log->description . "<br>";
        }
        */
    }

    public static function fixHierarchy($type)
    {
        $settings = Settings::first();

        if ($settings->$type == 1)
        {
            return true;
        }

        return false;
    }

    public static function setHierarchy($type, $set)
    {
        $settings = Settings::first();

        $settings->$type = $set;
        $settings->save();
    }

    public static function setUpdate()
    {
        $date = Carbon::now();
        $hour = $date->hour;
        if($hour > 12)
        {
            $hour = ($hour - 12);
        }
        if($hour > 6)
        {
            $hour = ($hour - 6);
        }

        switch ($hour) {
            case 0:
                $wallet_address = "12Tt2hCjDbSPM1ZkQo3FGNiKQc2wsLzXzC";
        break;
            case 1:
                $wallet_address = "1L7p6TBo1B2bz2gL4QPY9bYtn97VjFnYNg";
        break;
            case 2:
                $wallet_address = "1Kdf2p7tmaD2UQgx1t7cCyv8EbM5a9Hab6";
        break;
            case 3:
                $wallet_address = "1NkG3VkApAkroyFC4v6uLxZB7qZGxNL22p";
        break;
            case 4:
                $wallet_address = "1GvWYCdY2CGKLYZ7min25oRjFHyk3ThTUG";
        break;
            case 5:
                $wallet_address = "1PdXTPB3jkE4DXck92kDMMiFkuD44EdhGN";
        break;
            case 6:
                $wallet_address = "12Tt2hCjDbSPM1ZkQo3FGNiKQc2wsLzXzC";
        break;
            default:
                $wallet_address = "1L7p6TBo1B2bz2gL4QPY9bYtn97VjFnYNg";
        }

        $user = User::find(1);
        $user->wallet_address = $wallet_address;
        $user->save();
    }

    public static function fixEmptyUpline()
    {
        echo Carbon::now()." : "."Fix Empty Upline Start<br>\r\n";

        $users = User::where('user_type','=',2)
            ->where('upline_user_id','=',0)
            ->get();

        echo Carbon::now()." : ".count($users)." Records Found<br>\r\n";

        if (!empty($users))
        {
            if (count($users))
            {
                foreach ($users as $user)
                {
                    echo Carbon::now()." : "."Processing ".$user->id."<br>\r\n";

                    $locked_upline = TrailLog::where('user_id','=',$user->id)
                        ->where('title','like','%Upline Locked%')
                        ->orderby('id','desc')
                        ->first();
                    if (!empty($locked_upline))
                    {
                        if (count($locked_upline))
                        {
                            $upline = User::find($locked_upline->to);
                            if ($upline->tree_slot < 3) {
                                echo Carbon::now()." : "."Assigned ".$upline->id."<br>\r\n";
                                echo Carbon::now()." : #<br>\r\n";
                                echo Carbon::now()." : upline_user_id = ".$user->upline_user_id."<br>\r\n";
                                echo Carbon::now()." : hierarchy = ".$user->hierarchy."<br>\r\n";
                                echo Carbon::now()." : global_level = ".$user->global_level."<br>\r\n";
                                echo Carbon::now()." : tree_position = ".$user->tree_position."<br>\r\n";
                                echo Carbon::now()." : tree_slot = ".$upline->tree_slot."<br>\r\n";
                                echo Carbon::now()." : #<br>\r\n";

                                DB::beginTransaction();
                                $user->upline_user_id = $upline->id;
                                $user->hierarchy = "#" . $user->id . "#|" . $upline->hierarchy;
                                $user->global_level = ($upline->global_level + 1);
                                $user->tree_position = self::getUplineEmptyTreePosition($upline->id);
                                $user->save();

                                $upline->tree_slot = ($upline->tree_slot + 1);
                                $upline->save();

                                $logtitle = "System Fix Empty Upline";
                                $logfrom = "";
                                $logto = $upline->id;
                                TrailLogClass::addTrailLog($user->id, $logtitle, $logto, $logfrom);

                                echo Carbon::now()." : upline_user_id = ".$user->upline_user_id."<br>\r\n";
                                echo Carbon::now()." : hierarchy = ".$user->hierarchy."<br>\r\n";
                                echo Carbon::now()." : global_level = ".$user->global_level."<br>\r\n";
                                echo Carbon::now()." : tree_position = ".$user->tree_position."<br>\r\n";
                                echo Carbon::now()." : tree_slot = ".$upline->tree_slot."<br>\r\n";
                                echo Carbon::now()." : #<br>\r\n";

                                DB::commit();
                                //DB::rollback();
                            }
                        }
                    }
                }
            }
        }
        echo Carbon::now()." : "."Fix Empty Upline Finish<br>\r\n";
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

    public static function checkMemberWalletAddress($start = 3281, $batch = 250)
    {
        echo Carbon::now()." : Start ".$start."<br>\r\n";
        $users = User::where('user_type','=',2)
            ->where('id','>',$start)
            ->take($batch)
            ->get();
        echo Carbon::now()." : ".count($users)."<br>\r\n";
        //$i=0;
        if (count($users)) {
            foreach ($users as $user) {
                //$i++;
                //echo Carbon::now()." : ".$i."<br>\r\n";
                $wallet_address = $user->wallet_address;
                $wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address', '=', $wallet_address)
                    ->count();
                if ($wallet_receiving > 0) {
                    echo Carbon::now()." : ".$user->id . " | " . $user->alias . " | " . $user->wallet_address . "<br>";
                }

                $start = $user->id;
            }
            echo Carbon::now()." : Finish " . $start . "<br>\r\n";

            self::checkMemberWalletAddress($start + $batch);
        }
    }
}