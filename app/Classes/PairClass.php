<?php
namespace App\Classes;

use App\BankPair;
use App\BankPH;
use App\User;
use App\Settings;
use DB;
use Carbon\Carbon;
use App\Classes\PHGHClass;
use App\Classes\BitcoinWalletClass;

class PairClass
{
    public static function getCurrentPair($user_id, $pair_move = 0)
    {
        $total_left = 0;
        $total_middle = 0;
        $total_right = 0;

        $paired_left = 0;
        $paired_middle = 0;
        $paired_right = 0;

        $users = User::where('upline_user_id', '=', $user_id)
            ->get();
        if (!empty($users))
        {
            if (count($users))
            {
                foreach ($users as $user)
                {
                    //$total_ph = BankPH::select(DB::raw('sum(bank_ph.value_in_btc) as total'))
                    $total_ph = DB::table(DB::raw('(SELECT user_id,least(sum(value_in_btc),30) as value_in_btc, 3 as status FROM `bank_ph` where (status = 3 and ph_type = 1) or (status = 6 and ph_type = 1) group by user_id order by user_id) bank_ph'))
                        ->select(DB::raw('sum(bank_ph.value_in_btc) as total'))
                        ->join('users', function($join) use ($user) {
                            $join->on('bank_ph.user_id', '=', 'users.id');
                            $join->on('users.hierarchy', 'like', DB::raw("'%#".$user->id."#%'"));
                        })
                        ->where('status', '=', '3')
                        //->where('ph_type', '=', '2') // Normal PH
                        ->first();

                    switch ($user->tree_position)
                    {
                        case 1:
                            $total_left = number_format($total_ph->total == "" || $total_ph->total == null ? 0 : $total_ph->total,8,'.','');
                            break;
                        case 2:
                            $total_middle = number_format($total_ph->total == "" || $total_ph->total == null ? 0 : $total_ph->total,8,'.','');
                            break;
                        case 3:
                            $total_right = number_format($total_ph->total == "" || $total_ph->total == null ? 0 : $total_ph->total,8,'.','');
                            break;
                    }
                }
            }
        }

        $pair = BankPair::select(DB::raw('sum(pair_left) as pair_left'), DB::raw('sum(pair_middle) as pair_middle'), DB::raw('sum(pair_right) as pair_right'), DB::raw('sum(flush) as flush'))
            ->where('user_id', '=', $user_id)
            ->first();
        if (!empty($pair))
        {
            if (count($pair))
            {
                $paired_left = number_format($pair->pair_left == "" || $pair->pair_left == null ? 0 : $pair->pair_left,8,'.','');
                $paired_middle = number_format($pair->pair_middle == "" || $pair->pair_middle == null ? 0 : $pair->pair_middle,8,'.','');
                $paired_right = number_format($pair->pair_right == "" || $pair->pair_right == null ? 0 : $pair->pair_right,8,'.','');
                $flushed = number_format($pair->flush == "" || $pair->flush == null ? 0 : $pair->flush,8,'.','');
                $paired_middle = number_format($paired_middle + $flushed,8,'.','');
            }
        }

        $balance_left = number_format($total_left - $paired_left,8,'.','');
        $balance_middle = number_format($total_middle - $paired_middle,8,'.','');
        $balance_right = number_format($total_right - $paired_right,8,'.','');

        $flush = 0;
        $pair_left = $balance_left;
        $pair_middle = $balance_middle;
        $pair_right = $balance_right;

        if ($pair_move == 1)
        {
            if (($balance_left + $balance_middle) > $balance_right) {
                $pair = $balance_right;

                if ($balance_left >= $balance_right)
                {
                    $pair_left = $balance_right;
                    $pair_middle = 0;
                } else {
                    $pair_middle = number_format($balance_middle - (($balance_left + $balance_middle) - $balance_right), 8);
                }

                $flush = number_format($balance_middle - $pair_middle,8,'.','');

            }
            elseif (($balance_left + $balance_middle) < $balance_right)
            {
                $pair = number_format($balance_left + $balance_middle,8,'.','');

                $pair_right = number_format($balance_left + $balance_middle,8,'.','');
            } else {
                $pair = $balance_right;
            }
        }
        elseif ($pair_move == 3)
        {
            if (($balance_right + $balance_middle) > $balance_left) {
                $pair = $balance_left;

                if ($balance_right >= $balance_left)
                {
                    $pair_right = $balance_left;
                    $pair_middle = 0;
                } else {
                    $pair_middle = number_format($balance_middle - (($balance_right + $balance_middle) - $balance_left), 8);
                }

                $flush = number_format($balance_middle - $pair_middle,8,'.','');
            }
            elseif (($balance_right + $balance_middle) < $balance_left)
            {
                $pair = number_format($balance_right + $balance_middle,8,'.','');

                $pair_left = number_format($balance_right + $balance_middle,8,'.','');
            } else {
                $pair = $balance_left;
            }
        } else {
            if ($balance_left  > $balance_right) {
                $pair = $balance_right;

                $pair_left = $balance_right;
                $pair_middle = 0;
            }
            elseif ($balance_left < $balance_right)
            {
                $pair = $balance_left;

                $pair_middle = 0;
                $pair_right = $balance_left;
            } else {
                $pair = $balance_right;

                $pair_middle = 0;
            }

            $flush = $balance_middle;
        }

        //Total All From Begining
        $return['total_left'] = $total_left;
        $return['total_middle'] = $total_middle;
        $return['total_right'] = $total_right;

        //Total Previous Pair
        $return['paired_left'] = $paired_left;
        $return['paired_middle'] = $paired_middle;
        $return['paired_right'] = $paired_right;

        //New Total
        $return['balance_left'] = $balance_left;
        $return['balance_middle'] = $balance_middle;
        $return['balance_right'] = $balance_right;

        //New Pair
        $return['pair_left'] = $pair_left;
        $return['pair_middle'] = $pair_middle;
        $return['pair_right'] = $pair_right;

        $return['pair'] = $pair;
        $return['flush'] = $flush;

        /*
        echo "total_left : $total_left<br>";
        echo "total_middle : $total_middle<br>";
        echo "total_right : $total_right<br>";

        echo "paired_left : $paired_left<br>";
        echo "paired_middle : $paired_middle<br>";
        echo "paired_right : $paired_right<br>";

        echo "balance_left : $balance_left<br>";
        echo "balance_middle : $balance_middle<br>";
        echo "balance_right : $balance_right<br>";

        echo "pair_left : $pair_left<br>";
        echo "pair_middle : $pair_middle<br>";
        echo "pair_right : $pair_right<br>";

        echo "pair : $pair<br>";
        echo "flush : $flush<br>";

        dd();
        */

        return $return;
    }

    public static function processPair()
    {
        $date = Carbon::now();
        $lastdate = Carbon::now()->addDays(-7);
        $month = $lastdate->month;
        $year = $lastdate->year;
        $day = $date->day;
        $hour = $date->hour;
        $min = $date->minute;

        echo Carbon::now()." : "."### Pairing - Start "."<br>\r\n";
        echo Carbon::now()." : "."Date: ".$date."<br>\r\n";
        echo Carbon::now()." : "."Lastdate: ".$lastdate."<br>\r\n";
        echo Carbon::now()." : "."Month: ".$month."<br>\r\n";
        echo Carbon::now()." : "."Year: ".$year."<br>\r\n";

        $setting = Settings::find(1);
        $pair_year = $setting->pair_year;
        $pair_month = $setting->pair_month;


        //if ($day == 1 && $hour == 0 && $min < 5) {
        if (($pair_year.$pair_month <> $year.$month) && (($day >= 1) && ($day <= 15))) {
            $setting->pair_year = $year;
            $setting->pair_month = $month;
            $setting->save();

            $users = User::select(DB::raw('users.id'),DB::raw('users.user_class'),DB::raw('users.pair_move'))//, DB::raw('left_leg.total_left'))
                ->where('user_type', '=', '2')
                /*->leftjoin(DB::raw('(select sum(value_in_btc) from bank_ph inner join users on users.id = bank_ph.user_id and bank_ph.status = 3 where users.hierarchy like concat("%#",users.id,"#%"))'))
                ->leftjoin('bank_pair', function($join) use($month,$year) {
                    $join->on('bank_pair.user_id', '=', 'users.id');
                    $join->on('bank_pair.id', '=', DB::raw("(select Max(id) from bank_pair bp where bp.user_id = users.id)"));
                    $join->on('bank_pair.year', '=', DB::raw($year));
                    $join->on('bank_pair.month', '=', DB::raw($month));
                })
                ->where(DB::raw('users.global_level'), '>', '9')
                ->whereNull(DB::raw('bank_pair.id'))
                */
                ->orderby('global_level')
                ->orderby(DB::raw('users.id'))
                //->take(500)
                ->get();

            foreach ($users as $user)
            {
                $user_id = $user->id;
                $user_class = $user->user_class == "" || $user->user_class == null ? "" : $user->user_class;
                $pair_move = $user->pair_move == "" || $user->pair_move == null ? "" : $user->pair_move;
                echo Carbon::now()." : ".$user_id."<br>\r\n";

                $current_pair = self::getCurrentPair($user->id, $pair_move);
                $total_left = $current_pair['total_left'];
                $total_middle = $current_pair['total_middle'];
                $total_right = $current_pair['total_right'];

                $paired_left = $current_pair['paired_left'];
                $paired_middle = $current_pair['paired_middle'];
                $paired_right = $current_pair['paired_right'];

                $balance_left = $current_pair['balance_left'];
                $balance_middle = $current_pair['balance_middle'];
                $balance_right = $current_pair['balance_right'];

                $pair_left = $current_pair['pair_left'];
                $pair_middle = $current_pair['pair_middle'];
                $pair_right = $current_pair['pair_right'];

                $pair = $current_pair['pair'];
                $flush = $current_pair['flush'];

                switch ($user->user_class)
                {
                    case 3:
                        $bonus_percent = 0.5;
                        break;
                    case 4:
                        $bonus_percent = 1;
                        break;
                    case 5:
                        $bonus_percent = 3;
                        break;
                    case 6:
                        $bonus_percent = 5;
                        break;
                    case 7:
                        $bonus_percent = 7;
                        break;
                    case 8:
                        $bonus_percent = 10;
                        break;
                    default:
                        $bonus_percent = 0;
                }
                $bonus_amount = (($pair / 100) * $bonus_percent);
                $bonus_amount_actual = $bonus_amount;

                $active_ph = PHGHClass::getPHTotal($user_id, "3", "=")['active'];
                if ($active_ph < 30)
                {
                    if ($bonus_amount > $active_ph)
                    {
                        $bonus_amount = $active_ph;
                    }
                }

                if ($pair_left <> 0  || $pair_middle <> 0 || $pair_right <> 0 || $balance_middle <> 0) {
                    self::addPair($user_id, $balance_left, $balance_middle, $balance_right, $pair_left, $pair_middle, $pair_right, $pair_move, $flush, $user_class, $bonus_percent, $bonus_amount, $bonus_amount_actual, $active_ph, $month, $year);
                    echo Carbon::now()." : ".$pair."<br>\r\n";
                }
            }
        }
        echo Carbon::now()." : "."### Pairing - Finish "."<br>\r\n";
    }

    public static function addPair($user_id, $total_left, $total_middle, $total_right, $pair_left, $pair_middle, $pair_right, $pair_move, $flush, $user_class, $bonus_percent, $bonus_amount, $bonus_amount_actual, $active_ph, $month, $year)
    {
        DB::beginTransaction();
        $bank_pair = new BankPair();
        $bank_pair->user_id = $user_id;
        $bank_pair->total_left = $total_left;
        $bank_pair->total_middle = $total_middle;
        $bank_pair->total_right = $total_right;
        $bank_pair->pair_left = $pair_left;
        $bank_pair->pair_middle = $pair_middle;
        $bank_pair->pair_right = $pair_right;
        $bank_pair->pair_move = $pair_move;
        $bank_pair->flush = $flush;
        $bank_pair->user_class = $user_class;
        $bank_pair->bonus_percent = $bonus_percent;
        $bank_pair->bonus_amount = $bonus_amount;
        $bank_pair->bonus_amount_actual = $bonus_amount_actual;
        $bank_pair->active_ph = $active_ph;
        $bank_pair->month = $month;
        $bank_pair->year = $year;
        $bank_pair->save();

        if ($bonus_percent > 0) {
            $shares_type = "FP";
            $bank_pair_id = $bank_pair->id;
            $secret = BitcoinWalletClass::generateSecret();
            SharesClass::setShares($user_id, $secret, $shares_type, $bank_pair_id, $user_id, $bonus_percent, $bonus_amount);
        }
        DB::commit();
    }

    public static function pairHistory($user_id)
    {
        $pair_history = BankPair::where('user_id', '=', $user_id)
            ->get();

        return $pair_history;
    }
}