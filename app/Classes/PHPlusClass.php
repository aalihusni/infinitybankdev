<?php
namespace App\Classes;

use App\User;
use App\BankPH;
use DB;
use Carbon\Carbon;
use App\Classes\PHGHClass;
use App\Classes\SharesClass;
use App\Classes\BitcoinWalletClass;

class PHPlusClass
{
    public static function getPHPlus()
    {
        $sql = BankPH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `on_hold_at`,"' . Carbon::now() . '") as ph_elapse'));
        $sql->where('ph_type', '=', 3);
        $ph_plus = $sql->where('status', '=', '3')
            ->get();

        if (!empty($ph_plus))
        {
            if (count($ph_plus))
            {
                foreach ($ph_plus as $ph)
                {
                    if ($ph->ph_elapse >= 30 || $ph->percent < 100)
                    {
                        $user_id = $ph->user_id;

                        //$total_ph_plus_active = PHGHClass::getPHTotal($user_id, "5", "<=", 3);
                        //$total_ph_needed = ($total_ph_plus_active['active'] * 5);

                        $total_ph_plus_active = $ph->value_in_btc;
                        $total_ph_needed = ($total_ph_plus_active * 5);

                        $dateFrom = Carbon::createFromFormat('Y-m-d H:i:s', $ph->on_hold_at);
                        $dateTo = Carbon::createFromFormat('Y-m-d H:i:s', $ph->on_hold_at)->addDays(30);

                        $requirement['total_recruitment'] = 0;
                        $requirement['total_ph_active'] = 0;
                        $requirement['recruitment'] = "";
                        $requirement = self::getRecruitment($user_id, $dateFrom, $dateTo);

                        if ($ph->percent < 100) {
                            if ($requirement['total_recruitment'] >= 10) {
                                if ($requirement['total_ph_active'] >= $total_ph_needed) {
                                    $ph->percent = 100;
                                    $ph->save();
                                }
                            }
                        }

                        if ($ph->ph_elapse >= 30)
                        {
                            DB::beginTransaction();

                            echo "PH+ ID: ".$ph->id."<br>";
                            echo "User ID: ".$ph->user_id."<br>";
                            echo "PH Value: ".$ph->value_in_btc."<br>";
                            echo "Recruit: ".$requirement['total_recruitment']."<br>";
                            echo "Recruit PH Value: ".$requirement['total_ph_active']."<br>";

                            $ph->status = 6;
                            $ph->save();

                            $percent = $ph->percent;
                            $shares_type_id = $ph->id;
                            $user_id = $ph->user_id;
                            $value_in_btc = $ph->value_in_btc;

                            //PH+ Capital
                            $shares_type = "PHPC";
                            $secret = BitcoinWalletClass::generateSecret();
                            SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $value_in_btc);
                            echo "Capital Credited: ".$value_in_btc."<br>";

                            if ($percent == 100) {
                                //PH+ Dividen
                                $shares_type = "PHPD";
                                $secret = BitcoinWalletClass::generateSecret();
                                SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $value_in_btc);
                                echo "Dividend Credited: ".$value_in_btc."<br>";
                            }
                            echo "<br><br>";
                            DB::commit();
                        }
                    }
                }
            }
        }
    }

    public static function getRecruitment($user_id, $dateFrom, $dateTo)
    {
        $recruitment = User::select(DB::raw('users.*'))
            ->join('pagb', function($join) use ($user_id, $dateFrom, $dateTo) {
                $join->on('users.id', '=', 'pagb.sender_user_id');
                $join->on('pagb.new_user_class', '=', DB::raw('1'));
                $join->on('users.referral_user_id', '=', DB::raw($user_id));
                $join->on(DB::raw('pagb.created_at'), '>=', DB::raw("'".$dateFrom."'"));
                $join->on(DB::raw('pagb.created_at'), '<=', DB::raw("'".$dateTo."'"));
            })
            ->groupby(DB::raw('users.id'))
            ->groupby(DB::raw('pagb.new_user_class'))
            ->get();

        if (count($recruitment)) {
            return self::getRecruitmentPH($recruitment, $dateFrom, $dateTo);
        } else {
            $return['total_recruitment'] = 0;
            $return['total_ph_active'] = 0;
            $return['recruitment'] = "";

            return $return;
        }
    }

    public static function getRecruitmentPH($recruitments, $dateFrom, $dateTo)
    {
        $total_ph_active = 0;
        $no = 0;
        $recruit = "";

        foreach ($recruitments as $recruitment)
        {
            $ph_active = BankPH::select(DB::raw('sum(value_in_btc) as total_btc'))
                ->where('user_id', '=', $recruitment->id)
                ->where('ph_type', '=', 1)
                ->where('status', '=', 3)
                ->where('created_at', '>=', DB::raw("'".$dateFrom."'"))
                ->where('created_at', '<=', DB::raw("'".$dateTo."'"))
                ->first()->total_btc;

            if ($ph_active > 0) {
                $no++;
                $data['no'] = $no;
                $data['fullname'] = $recruitment->firstname." ".$recruitment->lastname;
                $data['user_id'] = $recruitment->id;
                $data['alias'] = $recruitment->alias;
                $data['ph'] = number_format($ph_active,8);
                $recruit[] = $data;
            }
            $total_ph_active = $total_ph_active + $ph_active;
        }

        $return['total_recruitment'] = $no;
        $return['total_ph_active'] = number_format($total_ph_active,1);
        $return['recruitment'] = $recruit;

        return $return;
    }
}