<?php
namespace App\Classes;

use App\MicroShares;
use DB;

class MicroSharesClass
{
    public static function SatoshiToBtc($satoshi)
    {
        $btc = (string)($satoshi / 100000000);

        return (float)$btc;
    }

    public static function BtcToSatoshi($btc)
    {
        $satoshi = (string)($btc * 100000000);

        return (int)$satoshi;
    }

    public static function getPHBonusPerUser($user_id, $sender_user_id)
    {
        $bonus_total = MicroShares::select(DB::raw('sum(debit_value_in_btc) as bonus_total'))
            ->where('user_id', '=', $user_id)
            ->where('shares_type_user_id', '=', $sender_user_id)
            ->first();

        $bonus_total = $bonus_total->bonus_total;

        return $bonus_total;
    }

    public static function getSharesTransactions($user_id, $shares_type = "", $shares_type_id = "")
    {
        $sql = MicroShares::where('user_id', '=', $user_id);
        if (!empty($shares_type))
        {
            $sql->where('shares_type', '=', $shares_type);
            $sql->where('shares_type_id', '=', $shares_type_id);
        }
        $sql->orderby('created_at','desc');
        $shares = $sql->get();

        if (!empty($shares))
        {
            if (count($shares))
            {
                $i = 0;
                foreach ($shares as $share) {
                    $i++;
                    $data['no'] = $i;
                    $data['created_at'] = $share->created_at;
                    $data['shares_type'] = $share->shares_type;
                    $data['shares_type_id'] = $share->shares_type_id;
                    $data['debit_value_in_btc'] = $share->debit_value_in_btc;
                    $data['credit_value_in_btc'] = $share->credit_value_in_btc;
                    $data['balance_value_in_btc'] = $share->balance_value_in_btc;

                    $return[] = $data;
                }

                return $return;
            }
        }

        return false;
    }

    public static function setSharesCredit($user_id, $credit_value_in_btc)
    {
        $credit_value = self::BtcToSatoshi(abs($credit_value_in_btc));
        $credited_value = 0;
        $balance_credit_value = $credit_value;

        $shares = MicroShares::where('user_id', '=', $user_id)
            ->where('credit_status', '<', 2)
            ->where('debit_value_in_btc', '>', 0)
            ->orderby('created_at', 'asc')
            ->get();

        if (!empty($shares))
        {
            if (count($shares))
            {
                DB::beginTransaction();
                foreach ($shares as $share)
                {
                    if ($credit_value > $credited_value) {
                        $shares_type = $share->shares_type;
                        $shares_type_id = 0;
                        $shares_type_user_id = 0;
                        $shares_type_percent = 0;
                        $debit_id = $share->id;

                        /*
                         * status = 0 (full)
                         * status = 1 (partial)
                         * status = 2 (empty)
                        */
                        if ($share->credit_status == 0) {
                            $debit_value = self::BtcToSatoshi($share->debit_value_in_btc);
                        } else {
                            $credit_total = self::BtcToSatoshi(abs(self::getCreditTotalByDebitID($user_id, $debit_id)));
                            $debit_value = self::BtcToSatoshi($share->debit_value_in_btc);
                            $debit_value = ($debit_value - $credit_total);
                        }

                        if ($debit_value > $balance_credit_value) {
                            $share->credit_status = 1;
                            $share->save();

                            $to_credit_value = $balance_credit_value;
                        } else {
                            $share->credit_status = 2;
                            $share->save();

                            $to_credit_value = $debit_value;
                        }

                        $credited_value = $credited_value + $to_credit_value;
                        $balance_credit_value = $credit_value - $credited_value;

                        $value_in_btc = -abs(self::SatoshiToBtc($to_credit_value));

                        self::setShares($user_id, $shares_type, $shares_type_id, $shares_type_user_id, $shares_type_percent, $value_in_btc, $debit_id);
                    }
                }
                DB::commit();
            }
        }
    }

    public static function getCreditTotalByDebitID($user_id, $debit_id)
    {
        $shares = MicroShares::select(DB::raw('sum(credit_value_in_btc) as credit_total'))
            ->where('user_id', '=', $user_id)
            ->where('debit_id', '=', $debit_id)
            ->first();
        $credit_total               = $shares->credit_total;

        return $credit_total;
    }

    public static function getSharesBalanceTypeAll($user_id)
    {
        //PR = passport bonus referral
        //PO = passport bonus overiding
        //BTC = deposit from bitcoin
        //PH = withdraw to ph
        //PHC = ph capital
        //PHD = ph dividen
        //PHR = ph referral
        //PHO = ph overiding
        //FP = ph pairing
        //FPR = ph pairing referral
        //FPO = ph pairing overiding
        //GH = withdraw to gh

        $balance_type['debit_total'] = 0;
        $balance_type['credit_total'] = 0;
        $balance_type['shares_balance'] = 0;

        $balance['PR'] = $balance_type;
        $balance['PO'] = $balance_type;
        $balance['BTC'] = $balance_type;
        $balance['PH'] = $balance_type;
        $balance['PHC'] = $balance_type;
        $balance['PHD'] = $balance_type;
        $balance['PHR'] = $balance_type;
        $balance['PHO'] = $balance_type;
        $balance['FP'] = $balance_type;
        $balance['FPR'] = $balance_type;
        $balance['FPO'] = $balance_type;
        $balance['GH'] = $balance_type;

        $balance['MPH'] = $balance_type;
        $balance['MPHC'] = $balance_type;
        $balance['MPHD'] = $balance_type;
        $balance['MGH'] = $balance_type;

        $shares = MicroShares::select(DB::raw('sum(debit_value_in_btc) as debit_total'), DB::raw('sum(credit_value_in_btc) as credit_total'), 'shares_type')
            ->where('user_id', '=', $user_id)
            ->groupby('shares_type')
            ->get();

        if (!empty($shares))
        {
            if (count($shares))
            {
                foreach ($shares as $share)
                {
                    $shares_type = $share->shares_type;
                    $debit_total = $share->debit_total;
                    $credit_total = $share->credit_total;
                    $shares_balance = ($debit_total + $credit_total);

                    $balance[$shares_type]['debit_total'] = number_format($debit_total, 8);
                    $balance[$shares_type]['credit_total'] = number_format($credit_total, 8);
                    $balance[$shares_type]['shares_balance'] = number_format($shares_balance, 8);
                }

                return $balance;
            }
        }

        return false;
    }

    public static function getSharesBalanceType($user_id, $shares_type)
    {
        $shares = MicroShares::select(DB::raw('sum(debit_value_in_btc) as debit_total'), DB::raw('sum(credit_value_in_btc) as credit_total'))
            ->where('user_id', '=', $user_id)
            ->where('shares_type', '=', $shares_type)
            ->first();

        $debit_total                = $shares->debit_total;
        $credit_total               = $shares->credit_total;
        $shares_balance             = ($debit_total + $credit_total);

        $return['debit_total']      = number_format($debit_total, 8);
        $return['credit_total']     = number_format($credit_total, 8);
        $return['shares_balance']   = number_format($shares_balance, 8);

        return $return;
    }

    public static function getSharesBalance($user_id)
    {
        $shares = MicroShares::select(DB::raw('sum(debit_value_in_btc) as debit_total'), DB::raw('sum(credit_value_in_btc) as credit_total'))
            ->where('user_id', '=', $user_id)
            ->first();
        $debit_total                = $shares->debit_total;
        $credit_total               = $shares->credit_total;
        $shares_balance             = ($debit_total + $credit_total);

        $shares = MicroShares::where('user_id', '=', $user_id)
            ->orderBy('id', 'desc')
            ->first();
        if (!empty($shares)) {
            $last_balance           = $shares->balance_value_in_btc;
        } else {
            $last_balance           = 0;
        }

        $return['debit_total']      = number_format($debit_total, 8);
        $return['credit_total']     = number_format($credit_total, 8);
        $return['shares_balance']   = number_format($shares_balance, 8);
        $return['last_balance']     = number_format($last_balance, 8);

        return $return;
    }

    public static function setShares($user_id, $shares_type, $shares_type_id, $shares_type_user_id, $shares_type_percent, $value_in_btc, $debit_id = "")
    {
        //PR = passport bonus referral
        //PO = passport bonus overiding
        //BTC = deposit from bitcoin
        //PH = withdraw to ph
        //PHC = ph capital
        //PHD = ph dividen
        //PHR = ph referral
        //PHO = ph overiding
        //FP = ph pairing
        //FPR = ph pairing referral
        //FPO = ph pairing overiding
        //GH = withdraw to gh

        if ($value_in_btc <> 0) {
            $get_shares_balance = self::getSharesBalance($user_id);
            $shares_balance = $get_shares_balance['shares_balance'];

            $shares = new MicroShares();
            $shares->user_id = $user_id;
            $shares->shares_type = $shares_type;
            $shares->shares_type_id = $shares_type_id;
            $shares->shares_type_user_id = $shares_type_user_id;
            $shares->shares_type_percent = $shares_type_percent;
            if ($value_in_btc > 0)
            { //deposit
                $shares->debit_value_in_btc = $value_in_btc;
            }
            elseif ($value_in_btc < 0)
            { //withdraw
                $shares->credit_value_in_btc = $value_in_btc;
                if (!empty($debit_id)) $shares->debit_id = $debit_id;
            }
            $shares->balance_value_in_btc = number_format(($shares_balance + $value_in_btc), 8);
            $shares->save();
        }
    }
}