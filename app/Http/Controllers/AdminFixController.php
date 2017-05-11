<?php

namespace App\Http\Controllers;

use App\Classes\SharesClass;
use Auth;
use Redirect;
use Crypt;
use Input;
use App\User;
use App\BitcoinBlockioWalletReceiving;
use App\Classes\PAGBClass;
use App\Classes\EmailClass;
use App\Classes\PassportClass;
use App\Classes\PAGBFixClass;
use App\Classes\BitcoinWalletClass;
use App\Shares;
use App\BankPH;
use DB;
use URL;
use Carbon\Carbon;

class AdminFixController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function getDuplicateShares()
    {
        $duplicates = Shares::select(DB::raw('count(id) as xcount'), DB::raw('shares.*'))
            ->where('id','<=','760094')
            ->where(function ($query) {
                $query->where('shares_type','=','PHD');
                $query->orwhere('shares_type','=','PHC');
            })
            ->groupby('user_id')
            ->groupby('shares_type')
            ->groupby('shares_type_id')
            ->groupby('debit_value_in_btc')
            ->groupby(DB::raw('hour(created_at)'))
            ->groupby(DB::raw('minute(created_at)'))
            ->orderby('xcount', 'desc')
            ->paginate(15);
            //->paginate(1000);

        echo count($duplicates)."<br>";

        $total_duplicate = 0;
        $i = 0;
        if (!empty($duplicates))
        {
            foreach ($duplicates as $duplicate)
            {
                if ($duplicate->xcount >= 2) {
                    $i = $i + 1;

                    if ($duplicate->shares_type != "GH") {
                        $user_id = $duplicate->user_id;
                        $shares_type = $duplicate->shares_type;
                        $shares_type_id = $duplicate->shares_type_id;
                        $debit_value_in_btc = $duplicate->debit_value_in_btc;
                        $hour = $duplicate->created_at->hour;
                        $minute = $duplicate->created_at->minute;

                        $shares_duplicate = ($duplicate->debit_value_in_btc * ($duplicate->xcount - 1));
                        $total_duplicate = ($total_duplicate + $shares_duplicate);

                        echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/".$duplicate->user_id."/".$duplicate->shares_type."/".$duplicate->shares_type_id."/".$duplicate->debit_value_in_btc."/".$hour."/".$minute."'>#".$i." | ".$duplicate->xcount . " | " . $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->created_at . "</a><br>";
                        //echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/".$duplicate->user_id."/".$duplicate->shares_type_id."/".$duplicate->debit_value_in_btc."'>".$duplicate->xcount . " | " . $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . "</a><br>";
                        //echo "<a style='text-decoration: none;' href='" . URL::to('/') . "/admin/duplicate-shares/secret/" . $duplicate->secret . "'>" . $duplicate->xcount . " | " . $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->secret . "</a><br>";

                        self::fixDuplicateSharesID($user_id, $shares_type, $shares_type_id, $debit_value_in_btc, $hour, $minute);
                    }
                } else {
                    return Redirect::to(URL::to('/')."/admin/home");
                }
            }
            echo "<br>";
            echo "Total Duplicate : ".$total_duplicate."<br>";

            return Redirect::to(URL::to('/')."/admin/duplicate-shares");
        }
    }

    public function getDuplicateSharesSec()
    {
        $duplicates = Shares::select(DB::raw('count(id) as xcount'), DB::raw('shares.*'))
            ->where('id','>','760094')
            ->groupby('secret')
            ->orderby('xcount', 'desc')
            ->paginate(1000);

        if (!empty($duplicates))
        {
            foreach ($duplicates as $duplicate)
            {
                if ($duplicate->xcount >= 2) {
                    //echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/".$duplicate->user_id."/".$duplicate->shares_type_id."/".$duplicate->debit_value_in_btc."'>".$duplicate->xcount . " | " . $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->secret . "</a><br>";
                    echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/secret/".$duplicate->secret."'>".$duplicate->xcount . " | " . $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->secret . "</a><br>";
                }
            }
        }
    }

    public function getDuplicateSharesSecret($secret)
    {
        echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/secret/fix/".$secret."'>Fix ".$secret . "</a><br><br>";

        $duplicates = Shares::where('secret','=',$secret)
            ->get();
        if (!empty($duplicates)) {
            foreach ($duplicates as $duplicate) {
                $user_id = $duplicate->user_id;
                $shares_type_id = $duplicate->shares_type_id;
                echo $duplicate->user_id." | ".$duplicate->shares_type." | ".$duplicate->shares_type_id." | ".$duplicate->debit_value_in_btc." | ".$duplicate->created_at."<br>";
            }
        }

        echo "<br>";
        echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/quick-login/".$user_id."'>Login</a><br><br>";
        echo "<br>";

        $get_ph = BankPH::find($shares_type_id);
        echo $get_ph->id." | ".$get_ph->user_id." | ".$get_ph->value_in_btc." | ".$get_ph->released_value_in_btc." | ".$get_ph->created_at."<br>";

        echo "<br>";

        $total_released = 0;
        $get_ph_shares = Shares::where('shares_type_id','=',$shares_type_id)
            ->where('user_id','=',$user_id)
            ->orderby('created_at')
            ->orderby('id')
            ->get();
        if (!empty($get_ph_shares)) {
            foreach ($get_ph_shares as $ph_shares) {
                echo $ph_shares->created_at." | ".$ph_shares->debit_value_in_btc." | ".$ph_shares->secret."<br>";
                $total_released =  $total_released + $ph_shares->debit_value_in_btc;
            }
        }

        echo "<br>";

        echo "Released = ".$total_released."<br>";
    }

    public function fixDuplicateSharesSecret($secret)
    {
        DB::beginTransaction();
        echo "Start<br>";
        $duplicates = Shares::where('secret','=',$secret)
            ->orderby('id')
            ->get();
        echo count($duplicates)."<br><br>";

        $i = 0;
        $x = 0;
        $duplicate_value = 0;
        if (!empty($duplicates)) {
            foreach ($duplicates as $duplicate) {
                //echo $i."<br>";
                //echo $x."<br><br>";

                $user_id = $duplicate->user_id;
                $shares_type_id = $duplicate->shares_type_id;

                if ($duplicate->shares_type == "PHD") {
                    if ($i > 0) {
                        $duplicate->user_id = "999" . $duplicate->user_id;
                        $duplicate->shares_type_user_id = "999" . $duplicate->shares_type_user_id;
                        $duplicate->secret = $duplicate->secret . "-" . $i;
                        $duplicate->save();
                        echo $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->secret . " | " . $duplicate->created_at . "<br>";
                        $duplicate_value = $duplicate_value + $duplicate->debit_value_in_btc;
                    } else {
                        echo "Before : ".$duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->secret . " | " . $duplicate->created_at . "<br>";
                    }
                    $i = $i + 1;
                }
                elseif ($duplicate->shares_type == "PHC") {
                    if ($x > 0) {
                        $duplicate->user_id = "999" . $duplicate->user_id;
                        $duplicate->secret = substr($duplicate->secret . $duplicate->secret, 0, 20) . "-" . $x;
                        $duplicate->save();
                        echo $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->secret . " | " . $duplicate->created_at . "<br>";
                    } else {
                        $duplicate->secret = substr($duplicate->secret . $duplicate->secret, 0, 20);
                        $duplicate->save();
                        echo $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->secret . " | " . $duplicate->created_at . "<br>";
                    }
                    $x = $x + 1;
                }
            }
        }

        $actual_ph_shares = Shares::select(DB::raw('sum(debit_value_in_btc) as xsum'))
            ->where('user_id','=',$user_id)
            ->where('shares_type','=','PHD')
            ->where('shares_type_id','=',$shares_type_id)
            ->first();

        echo "<br>";
        echo "Actual PH Share = ".$actual_ph_shares->xsum."<br>";
        echo "Duplicate PH Share = ".$duplicate_value."<br>";
        echo "Total PH Share = ".($actual_ph_shares->xsum + $duplicate_value)."<br>";
        echo "<br>";

        $ph = BankPH::find($shares_type_id);
        echo "PH Value : ".$ph->value_in_btc."<br>";
        echo "Date : ".$ph->created_at."<br>";

        echo "<br>";

        echo "PH Released Before : ".$ph->released_value_in_btc."<br>";
        $ph->released_value_in_btc = $actual_ph_shares->xsum;
        $ph->save();
        echo "PH Released After : ".$ph->released_value_in_btc."<br>";

        DB::commit();
    }


    //==============================================================

    //public function getDuplicateSharesID($user_id, $shares_type_id, $debit_value_in_btc)
    public function getDuplicateSharesID($user_id, $shares_type, $shares_type_id, $debit_value_in_btc, $hour, $minute)
    {
        echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/fix/".$user_id."/".$shares_type."/".$shares_type_id."/".$debit_value_in_btc."/".$hour."/".$minute."'>Fix </a><br><br>";
        //echo "<a style='text-decoration: none;' href='".URL::to('/')."/admin/duplicate-shares/fix/".$secret."'>Fix ".$secret . "</a><br><br>";
        
        $duplicates = Shares::where('user_id','=',$user_id)
            ->where('shares_type','=',$shares_type)
            ->where('shares_type_id','=',$shares_type_id)
            ->where('debit_value_in_btc','=',$debit_value_in_btc)
            ->where(function ($query) use ($hour) {
                $query->whereraw('hour(created_at)='.$hour);
                if ($hour == 23) {
                    $query->orwhereraw('hour(created_at)=0');
                    $query->orwhereraw('hour(created_at)=22');
                }
                elseif ($hour == 0) {
                    $query->orwhereraw('hour(created_at)=1');
                    $query->orwhereraw('hour(created_at)=23');
                }
                else {
                    $query->orwhereraw('hour(created_at)=' . ($hour + 1));
                    $query->orwhereraw('hour(created_at)=' . ($hour - 1));
                }
            })
            ->where(function ($query) use ($minute) {
                $query->whereraw('minute(created_at)='.$minute);
                if ($minute == 59) {
                    $query->orwhereraw('minute(created_at)=0');
                    $query->orwhereraw('minute(created_at)=58');
                }
                elseif ($minute == 0) {
                    $query->orwhereraw('minute(created_at)=1');
                    $query->orwhereraw('minute(created_at)=59');
                }
                else {
                    $query->orwhereraw('minute(created_at)=' . ($minute + 1));
                    $query->orwhereraw('minute(created_at)=' . ($minute - 1));
                }
            })
            ->get();
        $duplicate_value = 0;
        if (!empty($duplicates)) {
            foreach ($duplicates as $duplicate) {
                $duplicate_value = $duplicate_value + $debit_value_in_btc;
                echo $duplicate->user_id." | ".$duplicate->shares_type." | ".$duplicate->shares_type_id." | ".$duplicate->debit_value_in_btc." | ".$duplicate->created_at."<br>";
            }
        }
        $duplicate_value = $duplicate_value - $debit_value_in_btc;
        echo "Duplicate Value = ".$duplicate_value."<br>";

        echo "<br>";

        $get_ph = BankPH::find($shares_type_id);
        echo $get_ph->id." | ".$get_ph->user_id." | ".$get_ph->value_in_btc." | ".$get_ph->released_value_in_btc." | ".$get_ph->created_at."<br>";

        echo "<br>";

        $total_released = 0;
        $get_ph_shares = Shares::where('shares_type_id','=',$shares_type_id)
            ->orderby('created_at')
            ->orderby('id')
            ->get();
        if (!empty($get_ph_shares)) {
            foreach ($get_ph_shares as $ph_shares) {
                echo $ph_shares->created_at." | ".$ph_shares->shares_type." | ".$ph_shares->debit_value_in_btc." | ".$ph_shares->credit_value_in_btc."<br>";
                $total_released =  $total_released + $ph_shares->debit_value_in_btc;
            }
        }

        echo "<br>";

        echo "Released = ".$total_released."<br>";

    }

    public function fixDuplicateSharesID($user_id, $shares_type, $shares_type_id, $debit_value_in_btc, $hour, $minute)
    {
        DB::beginTransaction();

        $duplicates = Shares::where('user_id','=',$user_id)
            ->where('shares_type','=',$shares_type)
            ->where('shares_type_id','=',$shares_type_id)
            ->where('debit_value_in_btc','=',$debit_value_in_btc)
            ->where(function ($query) use ($hour) {
                $query->whereraw('hour(created_at)='.$hour);
                if ($hour == 23) {
                    $query->orwhereraw('hour(created_at)=0');
                    $query->orwhereraw('hour(created_at)=22');
                }
                elseif ($hour == 0) {
                    $query->orwhereraw('hour(created_at)=1');
                    $query->orwhereraw('hour(created_at)=23');
                }
                else {
                    $query->orwhereraw('hour(created_at)=' . ($hour + 1));
                    $query->orwhereraw('hour(created_at)=' . ($hour - 1));
                }
            })
            ->where(function ($query) use ($minute) {
                $query->whereraw('minute(created_at)='.$minute);
                if ($minute == 59) {
                    $query->orwhereraw('minute(created_at)=0');
                    $query->orwhereraw('minute(created_at)=58');
                }
                elseif ($minute == 0) {
                    $query->orwhereraw('minute(created_at)=1');
                    $query->orwhereraw('minute(created_at)=59');
                }
                else {
                    $query->orwhereraw('minute(created_at)=' . ($minute + 1));
                    $query->orwhereraw('minute(created_at)=' . ($minute - 1));
                }
            })
            //->where(DB::raw('hour(created_at)='.$hour))
            //->where(DB::raw('minute(created_at)='.$minute))
            ->orderby('id')
            ->get();

        $i = 0;
        $duplicate_value = 0;
        if (!empty($duplicates)) {
            foreach ($duplicates as $duplicate) {
                if ($i > 0) {
                    $duplicate_value = number_format($duplicate_value + $duplicate->debit_value_in_btc,8);

                    $user_id = $duplicate->user_id;
                    $shares_type = $duplicate->shares_type . "-REVERSAL";
                    $shares_type_id = $duplicate->shares_type_id;
                    $shares_type_user_id = $duplicate->shares_type_user_id;
                    $shares_type_percent = $duplicate->shares_type_percent;
                    $value_in_btc = (-1 * abs($duplicate->debit_value_in_btc));
                    $debit_id = $duplicate->debit_id;
                    $secret = BitcoinWalletClass::generateSecret();

                    echo $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->created_at . "<br>";
                    $duplicate->secret = $duplicate->secret . "-1";
                    $duplicate->shares_type = $duplicate->shares_type . "-DUPLICATE";
                    $duplicate->save();
                    echo $duplicate->user_id . " | " . $duplicate->shares_type . " | " . $duplicate->shares_type_id . " | " . $duplicate->debit_value_in_btc . " | " . $duplicate->created_at . "<br>";

                    SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $shares_type_user_id, $shares_type_percent, $value_in_btc, $debit_id);
                }

                $i = $i + 1;
            }

            $actual_ph_shares = Shares::select(DB::raw('sum(debit_value_in_btc) as sum_debit'), DB::raw('sum(credit_value_in_btc) as sum_credit'))
                ->where('user_id','=',$user_id)
                ->where('shares_type','=','PHD')
                ->where('shares_type_id','=',$shares_type_id)
                ->first();

            echo "<br>";
            $total_sum = ($actual_ph_shares->sum_debit + $actual_ph_shares->sum_credit);
            echo "Actual PH Share = ".$total_sum."<br>";
            echo "Duplicate PH Share = ".$duplicate_value."<br>";
            echo "Total PH Share = ".($total_sum + $duplicate_value)."<br>";
            echo "<br>";

            $ph = BankPH::find($shares_type_id);
            echo "PH Value : ".$ph->value_in_btc."<br>";
            echo "Date : ".$ph->created_at."<br>";

            echo "<br>";

            echo "PH Released Before : ".$ph->released_value_in_btc."<br>";
            $ph->released_value_in_btc = $total_sum;
            $ph->save();
            echo "PH Released After : ".$ph->released_value_in_btc."<br>";

        }

        DB::commit();
    }
}