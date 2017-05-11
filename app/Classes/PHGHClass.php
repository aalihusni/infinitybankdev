<?php
namespace App\Classes;

use App\BankPH;
use App\BankGH;
use App\BankPHGH;
use App\Settings;
use App\BitcoinBlockioWalletReceiving;
use App\BitcoinBlockioCallback;
use App\Classes\SharesClass;
use App\User;
use App\TrailLog;
use DB;
use Carbon\Carbon;
use App\Classes\PassportClass;
use App\Classes\BlockioWalletClass;
use App\Classes\TrailLogClass;

class PHGHClass
{
    /*
     * #PH @ GH
     * 0 = queue
     * 1 = assign partial & queue
     * 2 = assign full
     * 3 = active / completed
     * 4 = on hold
     * 5 = released
     * 6 = cancel / ended
     * 7 = expired
     * 8 = canceled
     */

    /*
     * #PHGH
     * 0 = pending
     * 1 = waiting confirmation
     * 2 = confirmed / completed
     * 3 = expired
     */

    public static $day_queue = 3; //How many days to queue PH & GH before assign
    public static $day_assigned_expiry = 1; //How many days after assigned to expired
    public static $day_matured = 20; //How many days for on hold & active ph to matured
    public static $expired_limit = 3; //How many expired per ph before ended

    //==================================================
    // Check Callback
    public static function checkPHGHCallback($phgh_id)
    {
        $wallet_receiving = BitcoinBlockioWalletReceiving::where('payment_type','=','PH')
            ->where('payment_specific','=',$phgh_id)
            ->orderby('id','desc')
            ->get();

        if (!empty($wallet_receiving))
        {
            if (count($wallet_receiving))
            {
                foreach ($wallet_receiving as $wallet)
                {
                    $receiving_address = $wallet->receiving_address;
                    $status = self::checkCallback($receiving_address);
                    if (!$status)
                    {
                        echo Carbon::now()." : "."### PHGH No Callback - ".$phgh_id."<br>\r\n";
                        $trail_log = TrailLog::where('title','like','PHGH No Callback')
                            ->where('to','=',$phgh_id)
                            ->first();
                        if (!empty($trail_log))
                        {
                            if (count($trail_log))
                            {

                            } else {
                                TrailLogClass::addTrailLog(1, "PHGH No Callback", $phgh_id);
                            }
                        } else {
                            TrailLogClass::addTrailLog(1, "PHGH No Callback", $phgh_id);
                        }
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public static function checkCallback($receiving_address)
    {
        $time_now = Carbon::now();
        $callback = BitcoinBlockioCallback::where('receiving_address','=',$receiving_address)
            ->orderby('id','desc')
            ->first();
        if (!empty($callback))
        {
            if (count($callback))
            {
                //$time_last = $callback->created_at;
                //$time_diff = $time_now->diffInHours($time_last);
                //if ($time_diff < 1)
                //{
                    return true;
                //}
            }
        }

        return false;
    }

    //==================================================
    // Payment

    //Get PH Payment Details
    public static function getPHPaymentDetails($phgh_id)
    {
        $phgh = self::getPHGH($phgh_id);
        $sender_user_id = $phgh['ph_user_id'];
        $receiver_user_id = $phgh['gh_user_id'];
        $value_in_btc = $phgh['value_in_btc'];

        $receiving_address = BlockioWalletClass::getReceivingAddressUser($receiver_user_id, $sender_user_id, "PH", $value_in_btc, $phgh_id)['receiving_address'];

        $return['phgh_id'] = $phgh_id;
        $return['sender_user_id'] = $sender_user_id;
        $return['receiver_user_id'] = $receiver_user_id;
        $return['receiving_address'] = $receiving_address;
        $return['value_in_btc'] = $value_in_btc;
        $return['phgh'] = $phgh;

        return $return;
    }

    //Pledge PH Matured
    public static function pledgPHMatured($ph_id)
    {
        $day_matured = self::$day_matured;
        $bankph = BankPH::find($ph_id);

        if ($bankph->status == 4)
        {
            $date_on_hold = Carbon::createFromFormat('Y-m-d H:i:s', $bankph->on_hold_at);
            $date_now = Carbon::now();
            $total_day = $date_on_hold->diffInDays($date_now);

            if ($total_day >= $day_matured)
            {
                DB::beginTransaction();

                echo Carbon::now()." : "."Pledge PH Matured (Process)<br>\r\n";
                $status = 6; //Ended
                $ph_id = $bankph->id;
                $value_in_btc = $bankph->dividen_value_in_btc;

                $secret = BitcoinWalletClass::generateSecret();
                self::releasePHProfit($ph_id, $value_in_btc, $secret);

                $bankph->status = $status;
                $bankph->save();

                DB::commit();
            }
        }
    }

    //Pledge PH To Completed
    public static function pledgePHCompleted($ph_id, $percent = 1)
    {
        $ph = self::getPH($ph_id);

        if ($ph['status'] == 2)
        {
            $bankph = BankPH::find($ph_id);

            if (!empty($bankph)) {
                if (count($bankph)) {
                    if ($bankph->ph_type == 0) {
                        DB::beginTransaction();

                        $status = 4; //On Hold
                        $bankph->status = $status;
                        $bankph->dividen_value_in_btc = $ph['dividen_total_in_btc'];
                        $bankph->on_hold_at = Carbon::now();

                        $status = 3; //Active
                        $user_id = $bankph->user_id;
                        $ph_type = 1; //Completed Pledge PH @ Active PH
                        $value_in_btc = $bankph->value_in_btc;

                        $secret = BitcoinWalletClass::generateSecret();
                        $link_ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $secret, $status, "", $ph_id);

                        $bankph->link_ph_id = $link_ph_id;
                        $bankph->save();

                        /*
                         * Give Bonus
                         */
                        self::addPHBonus($user_id, $ph_id, $value_in_btc);

                        DB::commit();
                    }

                    if ($bankph->ph_type == 2) {
                        DB::beginTransaction();

                        $status = 3; //Active
                        $ph_type = 3; //PH+
                        $percent = 0;

                        $bankph->status = $status;
                        $bankph->ph_type = $ph_type;
                        $bankph->percent = $percent;
                        $bankph->on_hold_at = Carbon::now();
                        $bankph->save();

                        DB::commit();
                    }
                }
            }
        }
    }

    public static function pledgePHExpired($ph_id, $percent = 1)
    {
        $ph = self::getPH($ph_id);
        $expired_limit = self::$expired_limit;
        $assign_ph_pending_value = self::getAssignedPHPendingValue($ph_id);
        $assign_ph_paid_value = self::getAssignedPHPaidValue($ph_id);

        if ($ph['status'] <= 1 && $ph['expired'] >= $expired_limit && $assign_ph_pending_value == 0)
        {
            $bankph = BankPH::find($ph_id);

            if (!empty($bankph)) {
                if (count($bankph)) {
                    if ($assign_ph_paid_value < $ph['value_in_btc'])
                    {
                        DB::beginTransaction();

                        $status = 7; //Expired
                        $bankph->status = $status;

                        if ($assign_ph_paid_value > 0)
                        {
                            $status = 3; //Active
                            $user_id = $bankph->user_id;
                            $ph_type = 1; //Completed Pledge PH @ Active PH
                            //$value_in_btc = $bankph->value_in_btc;
                            $value_in_btc = $assign_ph_paid_value;

                            $secret = BitcoinWalletClass::generateSecret();
                            $link_ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $secret, $status, "", $ph_id);

                            $bankph->link_ph_id = $link_ph_id;
                            $bankph->save();

                            /*
                            * Give Bonus
                            */
                            self::addPHBonus($user_id, $ph_id, $value_in_btc);
                        } else {
                            $bankph->save();
                        }

                        DB::commit();
                    }
                }
            }
        }
    }

    //Set GH To Completed
    public static function GHCompleted($gh_id)
    {
        $gh = self::getGH($gh_id);

        if ($gh['status'] == 2)
        {
            $status = 6; //Ended
            self::setGH($gh_id, $status);
        }
    }

    //Check GH Payment Status
    public static function checkGHPaymentStatusAll()
    {
        $bankgh = BankGH::where('status', '=', '2')
            ->get();

        if (!empty($bankgh))
        {
            if (count($bankgh))
            {
                foreach ($bankgh as $gh)
                {
                    $gh_id = $gh->id;
                    $payment_status = self::getPHGHPaymentStatusAll("gh", $gh_id);

                    //GH Completed
                    if ($payment_status) {
                        echo Carbon::now()." : "."GH Completed : ".$gh_id."<br>\r\n";
                        TrailLogClass::addTrailLog($gh->user_id, "GH Completed", $gh_id);
                        self::GHCompleted($gh_id);
                    }
                }
            }
        }

        return true;
    }

    //Check If PH Payment Status Is Completed Or Matured
    public static function checkPHPaymentStatusAll()
    {
        $bankph = BankPH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `on_hold_at`,"'.Carbon::now().'") as day_on_hold'))
            ->where('status', '=', '2')
            ->orwhere('status', '=', '4')
            ->get();

        if (!empty($bankph))
        {
            if (count($bankph))
            {
                foreach ($bankph as $ph)
                {
                    $ph_id = $ph->id;

                    if ($ph->status == 2) {
                        $payment_status = self::getPHGHPaymentStatusAll("ph", $ph_id);
                        $percent = 1;

                        //Pledge Completed
                        if ($payment_status) {
                            echo Carbon::now()." : "."Pledge PH Completed : ".$ph_id."<br>\r\n";
                            TrailLogClass::addTrailLog($ph->user_id, "Pledge PH Completed", $ph_id);
                            self::pledgePHCompleted($ph_id, $percent);
                        }
                    }

                    if ($ph->status == 4) {
                        //Pledge Matured
                        if ($ph->day_on_hold >= 20) {
                            echo Carbon::now()." : "."Pledge PH Matured : ".$ph_id."<br>\r\n";
                            TrailLogClass::addTrailLog($ph->user_id, "Pledge PH Matured", $ph_id);
                            self::pledgPHMatured($ph_id);
                        }
                    }
                }
            }
        }

        return true;
    }

    //Check If PH Payment Status Is Expired
    public static function checkPHPaymentExpiredAll()
    {
        $bankph = BankPH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `on_hold_at`,"'.Carbon::now().'") as day_on_hold'))
            ->where('status', '<=', '1')
            ->get();

        if (!empty($bankph))
        {
            if (count($bankph))
            {
                foreach ($bankph as $ph)
                {
                    $ph_id = $ph->id;
                    $payment_status = self::getPHGHPaymentStatusAll("ph", $ph_id);

                    if ($payment_status)
                    {
                        if ($ph->expired >= self::$expired_limit) {
                            //Pledge Expired
                            echo Carbon::now()." : "."Pledge PH Expired : ".$ph_id."<br>\r\n";
                            TrailLogClass::addTrailLog($ph->user_id, "Pledge PH Expired", $ph_id);
                            self::pledgePHExpired($ph_id);
                        }
                    }
                }
            }
        }

        return true;
    }

    //Check All PHGH Payment Status Is Completed
    public static function  getPHGHPaymentStatusAll($type, $id)
    {
        $sql = BankPHGH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '") as day_assigned'));
        if ($type == "ph") {
            $sql->where('ph_id', '=', $id);
        } else {
            $sql->where('gh_id', '=', $id);
        }
        $bankphgh = $sql->where('status', '<=', '3')
            ->get();

        $return = true;
        $day_assigned_expiry = self::$day_assigned_expiry;

        if (!empty($bankphgh))
        {
            if (count($bankphgh))
            {
                foreach ($bankphgh as $phgh)
                {
                    /*
                    // Check using wallet status

                    $payment_status = self::getPHGHPaymentStatus($phgh->id);

                    if (!$payment_status)
                    {
                        $return = false;
                    }
                    */

                    // Check using PHGH status
                    if ($phgh->status == 0) // Pending
                    {
                        if ($phgh->day_assigned >= $day_assigned_expiry)
                        {
                            $wallet_receiving = BitcoinBlockioWalletReceiving::where('payment_type','=','PH')
                                ->where('payment_specific','=',$phgh->id)
                                ->orderby('id','desc')
                                ->first();
                            $generated_wallet_receiving = false;
                            if (!empty($wallet_receiving))
                            {
                                if ($wallet_receiving)
                                {
                                    $generated_wallet_receiving = true;
                                }
                            }

                            if ($generated_wallet_receiving)
                            {
                                echo Carbon::now() . " : " . "PHGH " . $phgh->id . " On Hold" . "<br>\r\n";
                                TrailLogClass::addTrailLog($phgh->ph_user_id, "PHGH On Hold", $phgh->id);
                                TrailLogClass::addTrailLog($phgh->gh_user_id, "PHGH On Hold", $phgh->id);

                                $status = 1; // On Hold
                                $phgh->status = $status;
                                $phgh->save();
                            } else {
                                echo Carbon::now()." : "."PHGH ".$phgh->id." Expired #0"."<br>\r\n";
                                TrailLogClass::addTrailLog($phgh->ph_user_id, "PHGH Expired #0", $phgh->id);
                                TrailLogClass::addTrailLog($phgh->gh_user_id, "PHGH Expired #0", $phgh->id);

                                $status = 3; // Expired
                                $phgh->status = $status;
                                $phgh->save();

                                $status = 1; // Partial
                                $ph_id = $phgh->ph_id;
                                $gh_id = $phgh->gh_id;

                                self::setPH($ph_id, $status);
                                self::setGH($gh_id, $status);
                                self::setPHExpired($ph_id);

                                $phghid = $phgh->id;
                                $phghid = strtoupper(substr(md5($phghid),0,4)).$phghid;
                                $user = User::find($phgh->ph_user_id);
                                $email = $user->email;
                                $template = 'emails.ph_expired';
                                $subject = $user->alias.", Your PH that was matched is now expired! (ID: #$phghid)";
                                $data = array(
                                    'username'=>$user->alias,
                                    'phghid'=>$phghid
                                );
                                EmailClass::send_email($template, $email, $subject, $data, '0');
                            }
                        }
                        $return = false;
                    }
                    elseif ($phgh->status == 1) // On Hold
                    {
                        if ($phgh->day_assigned >= ($day_assigned_expiry + 1))
                        {
                            //$callback_status = self::checkPHGHCallback($phgh->id);
                            $callback_status = true;
                            if ($callback_status)
                            {
                                echo Carbon::now()." : "."PHGH ".$phgh->id." Expired #1"."<br>\r\n";
                                TrailLogClass::addTrailLog($phgh->ph_user_id, "PHGH Expired #1", $phgh->id);
                                TrailLogClass::addTrailLog($phgh->gh_user_id, "PHGH Expired #1", $phgh->id);

                                $status = 3; // Expired
                                $phgh->status = $status;
                                $phgh->save();

                                $status = 1; // Partial
                                $ph_id = $phgh->ph_id;
                                $gh_id = $phgh->gh_id;

                                self::setPH($ph_id, $status);
                                self::setGH($gh_id, $status);
                                self::setPHExpired($ph_id);

                                $phghid = $phgh->id;
                                $phghid = strtoupper(substr(md5($phghid),0,4)).$phghid;
                                $user = User::find($phgh->ph_user_id);
                                $email = $user->email;
                                $template = 'emails.ph_expired';
                                $subject = $user->alias.", Your PH that was matched is now expired! (ID: #$phghid)";
                                $data = array(
                                    'username'=>$user->alias,
                                    'phghid'=>$phghid
                                );
                                EmailClass::send_email($template, $email, $subject, $data, '0');
                            }
                        }
                        $return = false;
                    }
                }
            } else { $return = false; }
        } else { $return = false; }

        return $return;
    }

    //Check PHGH Payment Status
    public static function getPHGHPaymentStatus($phgh_id)
    {
        $payment_details = self::getPHPaymentDetails($phgh_id);
        $receiving_address = $payment_details['receiving_address'];
        $payment_status = BlockioWalletClass::getWalletReceivingStatus($receiving_address);

        return $payment_status;
    }

    //==================================================
    // Release

    public static function releasePH($ph_type, $ph_id, $value_in_btc = 0, $secret)
    {
        DB::beginTransaction();

        if ($ph_type == "profit") {
            self::releasePHProfit($ph_id, $value_in_btc, $secret);
        } else {
            self::releasePHAll($ph_id, $secret);
        }

        DB::commit();
    }

    public static function releasePHAll($ph_id, $secret)
    {
        $percent = "";
        $shares_type_id = $ph_id;
        $ph = self::getPH($ph_id);
        $user_id = $ph['user_id'];

        //PH
        $shares_type = "PHC";
        $ssecret = $secret.$secret;
        SharesClass::setShares($user_id, $ssecret, $shares_type, $shares_type_id, $user_id, $percent, $ph['value_in_btc']);

        //PH Dividen
        $shares_type = "PHD";
        SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $ph['dividen_now_in_btc']);


        //Update PH
        $status = 6; // Ended
        self::setPH($ph_id, $status, $ph['dividen_now_in_btc'], $ph['dividen_total_in_btc']);
    }

    public static function releasePHProfit($ph_id, $value_in_btc = 0, $secret)
    {
        $percent = "";
        $shares_type_id = $ph_id;
        $ph = self::getPH($ph_id);
        $user_id = $ph['user_id'];

        //PH Dividen
        $shares_type = "PHD";
        SharesClass::setShares($user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $value_in_btc);

        //Update PH
        $status = "";
        self::setPH($ph_id, $status, $value_in_btc);
    }

    //==================================================
    // Match

    public static function matchPHGH($priority = 0, $now = 0)
    {
        //Check if is there any PH & GH before trying to match
        $ph_count = self::getQueuePHCount($priority, $now);
        $gh_count = self::getQueueGHCount();

        echo Carbon::now()." : "."PH Count : ".$ph_count."<br>\r\n";
        echo Carbon::now()." : "."GH Count : ".$gh_count."<br>\r\n";
        if ($ph_count && $gh_count)
        {
            //Get list of PH
            $ph_list = self::getQueuePHList($priority, $now);

            echo Carbon::now()." : "."PH List : ".count($ph_list)."<br>\r\n";

            //Try to match all Queue PH
            foreach ($ph_list as $ph)
            {
                //Get PH balance value
                $ph_id = $ph->id;
                $ph_user_id = $ph->user_id;
                $ph_value = $ph->value_in_btc;
                $ph_assigned = self::getAssignedPHValue($ph->id);
                $ph_balance = $ph_value - $ph_assigned;
                echo Carbon::now()." : "."PH ID: ".$ph_id."\r\n";

                if ($ph->expired < self::$expired_limit)
                {
                    DB::beginTransaction();

                    //Check if PH balance above 0
                    if ($ph_balance > 0) {

                        //Check if is there any GH before assign PH
                        $gh_count = self::getQueueGHCount();
                        if ($gh_count) {
                            //Get list of GH
                            $gh_list = self::getQueueGHList();

                            echo Carbon::now()." : "."GH List : ".count($gh_list)."<br>\r\n";

                            //Try to match all Queue GH
                            foreach ($gh_list as $gh) {
                                //If shares balance below zero skip GH
                                echo Carbon::now()." : ".$gh->user_id." Balance Start"."<br>\r\n";
                                $shares_balance = SharesClass::getSharesBalance($gh->user_id)['shares_balance'];
                                echo Carbon::now()." : ".$gh->user_id." Balance Finish"."<br>\r\n";
                                if ($shares_balance >= 0) {
                                    //Get GH balance value
                                    $gh_id = $gh->id;
                                    $gh_user_id = $gh->user_id;
                                    $gh_value = $gh->value_in_btc;
                                    $gh_assigned = self::getAssignedGHValue($gh->id);
                                    $gh_balance = $gh_value - $gh_assigned;
                                    echo Carbon::now()." : "."GH ID: ".$gh_id."\r\n";

                                    //Check if GH balance above 0
                                    if ($gh_balance > 0) {

                                        if ($ph_balance > $gh_balance) {
                                            echo Carbon::now()." : "."use gh" . "<br>\r\n";
                                            //If PH is higher use GH balance
                                            $value_in_btc = $gh_balance;

                                            //Deduct PH & GH balance
                                            $ph_balance = ($ph_balance - $gh_balance);
                                            $gh_balance = ($gh_balance - $gh_balance);
                                        } elseif ($ph_balance < $gh_balance) {
                                            echo Carbon::now()." : "."use ph" . "<br>\r\n";
                                            //If GH is higher use PH balance
                                            $value_in_btc = $ph_balance;

                                            //Deduct PH & GH balance
                                            $ph_balance = ($ph_balance - $ph_balance);
                                            $gh_balance = ($gh_balance - $ph_balance);
                                        } else {
                                            echo Carbon::now()." : "."use both" . "<br>\r\n";
                                            //If GH is same use PH/GH balance
                                            $value_in_btc = $ph_balance;

                                            //Deduct PH & GH balance
                                            $ph_balance = 0;
                                            $gh_balance = 0;
                                        }

                                        if ($value_in_btc > 0) {
                                            //Match PH & GH
                                            $phghid = self::addPHGH($ph_id, $ph_user_id, $value_in_btc, $gh_user_id, $gh_id);
                                            $phghid = strtoupper(substr(md5($phghid), 0, 4)) . $phghid;
                                            $user = User::find($ph->user_id);
                                            $email = $user->email;
                                            $template = 'emails.ph_matched';
                                            $subject = $user->alias . ", Congratulations! Your Pledged PH is now matched. (ID: #$phghid)";
                                            $data = array(
                                                'username' => $user->alias,
                                                'phghid' => $phghid,
                                                'day_assigned_expiry' => self::$day_assigned_expiry,
                                                'expiry' => Carbon::now()->addDays(self::$day_assigned_expiry)->addMinutes(-5)
                                            );
                                            EmailClass::send_email($template, $email, $subject, $data, '1');
                                        }

                                        echo Carbon::now()." : ".$gh_balance . "<br>\r\n";
                                        if ($gh_balance == 0) {
                                            //This GH fully assigned. Update GH status
                                            $status = 2;
                                            $gh->status = $status;
                                            $gh->save();
                                        } else {
                                            //This GH partial assigned. Update GH status
                                            $status = 1;
                                            $gh->status = $status;
                                            $gh->save();
                                        }
                                        echo Carbon::now()." : "."gh status = " . $status . "<br>\r\n";

                                        if ($ph_balance == 0) {
                                            //This PH fully assigned. Update PH status and exit gh_list foreach
                                            $status = 2;
                                            $ph->status = $status;
                                            $ph->save();
                                            break 1;
                                        } else {
                                            //This PH partial assigned. Update PH status
                                            $status = 1;
                                            $ph->status = $status;
                                            $ph->save();
                                        }
                                    } else {
                                        echo Carbon::now()." : ".$gh->id . " This GH fully assigned<br>\r\n";

                                        //This GH fully assigned.
                                        $status = 2;
                                        $gh->status = $status;
                                        $gh->save();
                                    }
                                } else {
                                    //Skip/Ignore Negative Balance
                                    $gh->skip_ignore = 1;
                                    $gh->save();
                                }
                            }
                            DB::commit();
                        } else {
                            DB::commit();

                            //No GH Queue. Exit ph_list foreach
                            break 1;
                        }
                    } else {
                        echo Carbon::now()." : ".$ph->id . " This PH fully assigned<br>\r\n";

                        //This PH fully assigned.
                        $status = 2;
                        $ph->status = $status;
                        $ph->save();

                        DB::commit();
                    }
                } else {
                    if ($ph_balance == 0) {
                        echo Carbon::now()." : ".$ph->id . " This PH fully assigned<br>\r\n";

                        //This PH fully assigned.
                        $status = 2;
                        $ph->status = $status;
                        $ph->save();

                        DB::commit();
                    } else {
                        echo Carbon::now()." : ".$ph->id . " This PH expired<br>\r\n";
                    }
                }
            }
        }

        return false;
    }

    public static function getAssignedPHPaidValue($ph_id)
    {
        $ph = BankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '=', '2')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedPHPendingValue($ph_id)
    {
        $ph = BankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '=', '0')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedPHValue($ph_id)
    {
        $ph = BankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '<', '3')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedGHValue($gh_id)
    {
        $gh = BankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('gh_id', '=', $gh_id)
            ->where('status', '<', '3')
            ->first();
        $value_in_btc = $gh->value_in_btc;

        return $value_in_btc;
    }

    public static function getQueuePHList($priority = 0, $now = 0)
    {
        $day_queue = self::$day_queue;

        if ($now)
        {
            $ph_list = BankPH::where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->get();
        } else {
            $ph_list = BankPH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '")'), '>=', $day_queue)
                ->where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->get();
        }

        return $ph_list;
    }

    public static function getQueueGHList()
    {
        $day_queue = self::$day_queue;

        $gh_list = BankGH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"'.Carbon::now().'")'), '>=', $day_queue)
            ->where('status', '<', '2')
            ->where('skip_ignore', '=', '0')
            ->orderby('priority', 'desc')
            ->orderby('created_at', 'asc')
            ->orderby('id', 'asc')
            ->get();

        return $gh_list;
    }

    public static function getQueuePHCount($priority = 0, $now = 0)
    {
        $day_queue = self::$day_queue;

        if ($now)
        {
            $ph_count = BankPH::where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->count();
        } else {
            $ph_count = BankPH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '")'), '>=', $day_queue)
                ->where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->count();
        }

        return $ph_count;
    }

    public static function getQueueGHCount()
    {
        $day_queue = self::$day_queue;

        $gh_count = BankGH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"'.Carbon::now().'")'), '>=', $day_queue)
            ->where('status', '<', '2')
            ->where('skip_ignore', '=', '0')
            ->orderby('priority', 'desc')
            ->orderby('created_at', 'asc')
            ->orderby('id', 'asc')
            ->count();

        return $gh_count;
    }

    //==================================================
    // Database

    public static function createPH($user_id, $value_in_btc, $type, $secret, $onbehalf_user_id = "")
    {
        DB::beginTransaction();
        $status = null;

        //Passport
        if (empty($onbehalf_user_id)) {

            $passport_balance = PassportClass::getPassportBalance($user_id);
            $error['error'] = "Insufficient passport balance. Please purchase passport!";
            $error['redirect'] = "passport";
            if ($passport_balance == 0) return $error;

            $passport_id = PassportClass::setPassportBalance($user_id, -1, "PH");
            PassportClass::addPassportBonus($user_id, $passport_id);
        } else {
            $passport_balance = PassportClass::getPassportBalance($onbehalf_user_id);
            $error['error'] = "Insufficient passport balance. Please purchase passport!";
            $error['redirect'] = "passport";
            if ($passport_balance == 0) return $error;

            $passport_id = PassportClass::setPassportBalance($onbehalf_user_id, -1, "PH");
            PassportClass::addPassportBonus($user_id, $passport_id);
        }

        $percent = PHGHClass::getPercent($type);
        if ($type == "active") {
            $status = 3;
            $ph_type = 1;
        } elseif ($type == "queue") {
            $ph_type = 0;
        } elseif ($type == "plus") {
            $ph_type = 2;
        } else {
            $ph_type = 3;
        }

        $ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $secret, $status, $onbehalf_user_id);
        DB::commit();

        return $ph_id;
    }

    public static function createGH($user_id, $value_in_btc, $secret)
    {
        $passport_balance = PassportClass::getPassportBalance($user_id);
        $error['error'] = "Insufficient passport balance. Please purchase passport!";
        $error['redirect'] = "passport";
        if ($passport_balance == 0) return $error;

        $passport_id = PassportClass::setPassportBalance($user_id, -1, "GH");
        PassportClass::addPassportBonus($user_id, $passport_id);

        return self::addGH($user_id, $value_in_btc, $secret);
    }

    public static function addPHBonus($user_id, $shares_type_id, $value_in_btc)
    {
        $user = User::find($user_id);
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
                    $shares_type = "PHR";
                    break;
                case '2':
                    if ($upline_user_class >= 4) {
                        $percent = 5;
                        $shares_type = "PHO";
                    }
                    break;
                case '3':
                    if ($upline_user_class >= 5) {
                        $percent = 3;
                        $shares_type = "PHO";
                    }
                    break;
                case '4':
                    if ($upline_user_class >= 6) {
                        $percent = 1;
                        $shares_type = "PHO";
                    }
                    break;
                case '5':
                    if ($upline_user_class >= 7) {
                        $percent = 0.5;
                        $shares_type = "PHO";
                    }
                    break;
                case '6':
                    if ($upline_user_class >= 8) {
                        $percent = 0.1;
                        $shares_type = "PHO";
                    }
                    break;
            }

            if ($percent > 0) {
                // Bonus limit per user from specific user (3 BTC)
                $bonus_limit = 3;
                $bonus_total = SharesClass::getPHBonusPerUser($upline_user_id, $user_id);
                if ($bonus_total < $bonus_limit) {
                    $percent_value_in_btc = (($value_in_btc / 100) * $percent);
                    if (($bonus_total + $percent_value_in_btc) >= 3)
                    {
                        $percent_value_in_btc = ($bonus_limit - $bonus_total);
                    }

                    $status = 1;
                    $secret = BitcoinWalletClass::generateSecret();
                    SharesClass::setShares($upline_user_id, $secret, $shares_type, $shares_type_id, $user_id, $percent, $percent_value_in_btc);
                }
            }
        }
    }

    public static function getPercent($type)
    {
        $setting = Settings::orderby('id','desc')->first();
        if ($type == "queue") {
            $percent = $setting->ph_queue_percent;
        }
        elseif ($type == "active") {
            $percent = $setting->ph_active_percent;
        }
        else {
            $percent = 0;
        }

        return $percent;
    }

    public static function calcDividen($value_in_btc, $percent, $time_start)
    {
        $satoshi = 100000000;
        $value_in_satoshi = ($value_in_btc * $satoshi);

        //calc sec & milisec in 1 day
        $seconds_in_day = ((24 * 60) * 60);
        $miliseconds_in_day = ($seconds_in_day * 1000);

        //calc dividen in 1 day
        $dividen_day_in_satoshi = (($value_in_satoshi / 100) * $percent);
        $dividen_day_in_btc = number_format(($dividen_day_in_satoshi / $satoshi),8);

        //calc dividen in 1 sec
        $dividen_second_in_satoshi = ($dividen_day_in_satoshi / $seconds_in_day);
        $dividen_second_in_btc = number_format(($dividen_second_in_satoshi / $satoshi),8);

        //Get time elapse since start
        $time_now = Carbon::now();
        $time_start = Carbon::createFromFormat('Y-m-d H:i:s', $time_start);
        $total_sec = $time_now->diffInSeconds($time_start);
        $total_min = $time_now->diffInMinutes($time_start);
        $total_hour = $time_now->diffInHours($time_start);
        $total_day = $time_now->diffInDays($time_start);

        $dividen_in_satoshi = ($dividen_second_in_satoshi * $total_sec);
        $dividen_in_btc = number_format(($dividen_in_satoshi / $satoshi),8);

        $return['dividen_day_in_satoshi'] = str_replace(",", "", $dividen_day_in_satoshi);
        $return['dividen_day_in_btc'] = str_replace(",", "", $dividen_day_in_btc);
        $return['dividen_second_in_satoshi'] = str_replace(",", "", $dividen_second_in_satoshi);
        $return['dividen_second_in_btc'] = str_replace(",", "", $dividen_second_in_btc);
        $return['total_sec'] = $total_sec;
        $return['total_min'] = $total_min;
        $return['total_hour'] = $total_hour;
        $return['total_day'] = $total_day;
        $return['dividen_in_satoshi'] = str_replace(",", "", $dividen_in_satoshi);
        $return['dividen_in_btc'] = str_replace(",", "", $dividen_in_btc);

        return $return;
    }

    public static function getTotalActiveDividen($user_id, $status = "", $condition = "=")
    {
        $total_active_ph = 0;
        $total_active_dividen = 0;
        $total_second_dividen = 0;
        $total_second_dividen_satoshi = 0;
        $total_released_dividen = 0;

        $sql = BankPH::where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        $bankph = $sql->get();

        if (!empty($bankph))
        {
            if (count($bankph))
            {
                foreach ($bankph as $ph)
                {
                    $value_in_btc = $ph->value_in_btc;
                    $percent = $ph->percent;
                    $time_start = $ph->created_at;
                    $released_value_in_btc = $ph->released_value_in_btc;
                    $status = $ph->status;
                    $calc_dividen = self::calcDividen($value_in_btc, $percent, $time_start);
                    $dividen_now_in_btc = number_format(($calc_dividen['dividen_in_btc'] - $released_value_in_btc),8);
                    $dividen_second_in_btc = $calc_dividen['dividen_second_in_btc'];
                    $dividen_second_in_satoshi = $calc_dividen['dividen_second_in_satoshi'];

                    $total_active_dividen = ($total_active_dividen + $dividen_now_in_btc);
                    if ($status < 4) {
                        $total_active_ph = $total_active_ph + $value_in_btc;
                        $total_second_dividen = ($total_second_dividen + $dividen_second_in_btc);
                        $total_second_dividen_satoshi = ($total_second_dividen_satoshi + $dividen_second_in_satoshi);
                    }
                    $total_released_dividen = ($total_released_dividen + $released_value_in_btc);
                }
            }
        }

        $return['total_active_ph'] = number_format($total_active_ph,8);
        $return['total_active_dividen'] = number_format($total_active_dividen,8);
        $return['total_second_dividen'] = $total_second_dividen;
        $return['total_second_dividen_satoshi'] = $total_second_dividen_satoshi;
        $return['total_released_dividen'] = number_format($total_released_dividen,8);
        $return['balance_active_dividen'] = number_format(($total_active_dividen - $total_released_dividen),8);

        return $return;
    }

    public static function getPledgeActivePHTotal($user_id)
    {
        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'))
            ->where('user_id', '=', $user_id);
        $sql->where(function ($query) {
            $query->where('ph_type', '=', 0);
            $query->where('link_ph_id', '=', 0);
            $query->where('status', '<', 3);
            $query->orwhere('ph_type', '=', 1);
            $query->where('status', '=', 3);
        });
        $bankph = $sql->first();

        $total = $bankph->total;
        $balance = (30 - $total);

        $return['active'] = number_format($total,8);
        $return['balance'] = number_format($balance,8);

        return $return;
    }

    public static function getPHTotal($user_id, $status = "", $condition = "=", $ph_type = "")
    {
        $sql = BankPH::select(DB::raw('sum(value_in_btc) as total'))
            ->where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        if (empty($ph_type)) {
            $sql->where(function ($query) {
                $query->where('ph_type', '=', 0);
                $query->orwhere('ph_type', '=', 1);
            });
        } else {
            $sql->where('ph_type', '=', $ph_type);
        }
        /*
        if (!empty($ph_type)) {
            $sql->where('ph_type', '=', $ph_type);
        }
        */
        $bankph = $sql->first();

        $total = $bankph->total;
        $balance = (30 - $total);

        $return['active'] = number_format($total,8);
        $return['balance'] = number_format($balance,8);

        return $return;
    }

    public static function getGHTotal($user_id, $status = "", $condition = "=")
    {
        $sql = BankGH::select(DB::raw('sum(value_in_btc) as total'))
            ->where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        $bankgh = $sql->first();

        $total = $bankgh->total;
        $balance = (30 - $total);

        $return['active'] = number_format($total,8);
        $return['balance'] = number_format($balance,8);

        return $return;
    }

    /*
    public static function getPHGHAllTotal($type, $type_id, $status)
    {
        $bankphgh = BankPHGH::select(DB::raw('sum(value_in_btc) as total'))
            ->where($type."_id", '=', $type_id)
            ->where('status', '=', $status)
            ->first();

        $total = $bankphgh->total;

        return $total;
    }
    */
    public static function setPHExpired($ph_id)
    {
        $bankph = BankPH::find($ph_id);
        $bankph->expired = ($bankph->expired + 1);
        $bankph->save();

        return $bankph->expired;
    }

    public static function setPH($ph_id, $status = 0, $released_value_in_btc = 0, $dividen_value_in_btc = 0)
    {
        $bankph = BankPH::find($ph_id);
        if ($status == 6 && $bankph->status == 3)
        {
            $bankph->on_hold_at = Carbon::now();
        }
        if ($status > 0) {
            $bankph->status = $status;
        }
        $bankph->released_value_in_btc = ($bankph->released_value_in_btc  + $released_value_in_btc);
        if ($dividen_value_in_btc > 0)
        {
            $bankph->dividen_value_in_btc = $dividen_value_in_btc;
        }
        $bankph->save();
    }

    public static function setGH($gh_id, $status)
    {
        $bankgh = BankGH::find($gh_id);
        $bankgh->status = $status;
        $bankgh->save();
    }

    public static function setPHGH($phgh_id, $status)
    {
        $bankphgh = BankPHGH::find($phgh_id);
        $bankphgh->status = $status;
        $bankphgh->save();
    }

    /*
    public static function getAllPH($status = "", $condition = "=")
    {
        if (!empty($status)) {
            $bankph = BankPH::where('status', $condition, $status)
                ->get();
        } else {
            $bankph = BankPH::get();
        }

        return $bankph;
    }

    public static function getAllGH($status = "", $condition = "=")
    {
        if (!empty($status)) {
            $bankgh = BankGH::where('status', $condition, $status)
                ->get();
        } else {
            $bankgh = BankGH::get();
        }

        return $bankgh;
    }
    */

    public static function getGHQueueNo($gh_id)
    {
        $bankgh = BankGH::where('id', '<=', $gh_id)
            ->where('status', '<', 2)
            ->orderby('created_at', 'asc')
            ->count();

        $ghdate = BankGH::find($gh_id)->created_at;
        if ($ghdate > "2016-09-01 00:00:00") {
            $bankgh = ($bankgh + 200);
        }
        elseif ($ghdate > "2016-09-07 00:00:00")
        {
            $bankgh = ($bankgh + 300);
        }
        elseif ($ghdate > "2016-09-14 00:00:00")
        {
            $bankgh = ($bankgh + 400);
        }
        elseif ($ghdate > "2016-09-21 00:00:00")
        {
            $bankgh = ($bankgh + 500);
        }
        else {
            $bankgh = ($bankgh + 100);
        }

        return $bankgh;
    }

    public static function getPHStatus($id)
    {
        $ph_status = BankPH::find($id)->status;
        return $ph_status;
    }

    public static function getGHStatus($id)
    {
        $gh_status = BankGH::find($id)->status;
        return $gh_status;
    }

    public static function getPHGHStatus($id)
    {
        $phgh_status = BankPHGH::find($id)->status;
        return $phgh_status;
    }

    public static function getPH($ph_id)
    {
        $status_name[0] = "In Queue";
        $status_name[1] = "Partial";
        $status_name[2] = "Assigned";
        $status_name[3] = "Active";
        $status_name[4] = "On Hold";
        $status_name[5] = "Released";
        $status_name[6] = "Ended";
        $status_name[7] = "Expired";
        $status_name[8] = "Canceled";

        $bankph = BankPH::find($ph_id);
        $ph = $bankph;

        if (!empty($bankph))
        {
            if (count($bankph))
            {
                $return = "";

                $value_in_btc = $ph->value_in_btc;
                $released_value_in_btc = $ph->released_value_in_btc;
                $percent = $ph->percent;
                $time_start = $ph->created_at;
                $calc_dividen = self::calcDividen($value_in_btc, $percent, $time_start);
                $dividen_total_in_btc = $calc_dividen['dividen_in_btc'];
                $dividen_now_in_btc = ($dividen_total_in_btc - $released_value_in_btc);
                $dividen_value_in_btc = ($ph->dividen_value_in_btc - $released_value_in_btc);
                $total_day = $calc_dividen['total_day'];

                $data['id'] = $ph->id;
                $data['user_id'] = $ph->user_id;
                $data['ph_type'] = $ph->ph_type;
                $data['value_in_btc'] = number_format($value_in_btc,8);
                $data['dividen_value_in_btc'] = number_format($dividen_value_in_btc,8);
                $data['released_value_in_btc'] = number_format($released_value_in_btc,8);
                $data['day'] = $total_day;
                $data['percent'] = $percent;
                $data['dividen_total_in_btc'] = number_format($dividen_total_in_btc,8);
                $data['dividen_now_in_btc'] = number_format($dividen_now_in_btc,8);
                $data['status'] = $ph->status;
                $data['status_name'] = $status_name[$ph->status];
                $data['time_start'] = $time_start;
                $data['phgh'] = self::getPHGHAll($ph->id, 'ph');
                $data['shares'] = SharesClass::getSharesTransactions($ph->user_id, "PHD", $ph->id);
                $data['expired'] = $ph->expired;

                $return = $data;

                return $return;
            }
        }
    }

    public static function getGH($ph_id)
    {
        $status_name[0] = "In Queue";
        $status_name[1] = "Partial";
        $status_name[2] = "Assigned";
        $status_name[3] = "Completed";
        $status_name[4] = "On Hold";
        $status_name[5] = "Released";
        $status_name[6] = "Ended";
        $status_name[7] = "Expired";
        $status_name[8] = "Canceled";

        $bankgh = BankGH::find($ph_id);

        if (!empty($bankgh))
        {
            if (count($bankgh))
            {
                $return  = "";

                $value_in_btc = $bankgh->value_in_btc;
                $time_start = $bankgh->created_at;

                $data['id'] = $bankgh->id;
                $data['user_id'] = $bankgh->user_id;
                $data['value_in_btc'] = number_format($value_in_btc,8);
                $data['status'] = $bankgh->status;
                $data['status_name'] = $status_name[$bankgh->status];
                $data['time_start'] = $time_start;
                $data['phgh'] = self::getPHGHAll($bankgh->id, 'gh');
                if ($bankgh->status < 2)
                {
                    $data['queue'] = self::getGHQueueNo($bankgh->id);
                } else {
                    $data['queue'] = "-";
                }

                $return = $data;

                return $return;
            }
        }
    }

    public static function getPHGH($id)
    {
        $status_name[0] = "Pending";
        $status_name[1] = "Recheck";
        $status_name[2] = "Completed";
        $status_name[3] = "Expired";

        $bankphgh = BankPHGH::find($id);

        if (!empty($bankphgh))
        {
            if (count($bankphgh))
            {
                //$data['no'] = $i;
                $data['id'] = $bankphgh->id;
                $data['ph_id'] = $bankphgh->ph_id;
                $data['ph_user_id'] = $bankphgh->ph_user_id;
                $data['gh_id'] = $bankphgh->gh_id;
                $data['gh_user_id'] = $bankphgh->gh_user_id;
                $data['value_in_btc'] = number_format($bankphgh->value_in_btc,8);
                $data['status'] = $bankphgh->status;
                $data['status_name'] = $status_name[$bankphgh->status];
                $data['created_at'] = $bankphgh->created_at;

                $return = $data;

                return $return;
            }
        }
    }

    public static function getPHAll($user_id, $status = "", $condition = "=", $ph_type = "")
    {
        $status_name[0] = "In Queue";
        $status_name[1] = "Partial";
        $status_name[2] = "Assigned";
        $status_name[3] = "Active";
        $status_name[4] = "On Hold";
        $status_name[5] = "Released";
        $status_name[6] = "Ended";
        $status_name[7] = "Expired";
        $status_name[8] = "Canceled";

        $sql = BankPH::where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        if (empty($ph_type)) {
            $sql->where(function ($query) {
                $query->where('ph_type', '=', 0);
                $query->orwhere('ph_type', '=', 1);
            });
        } else {
            $sql->where(function ($query) {
                $query->where('ph_type', '=', 2);
                $query->orwhere('ph_type', '=', 3);
            });
        }
        $bankph = $sql->get();

        if (!empty($bankph))
        {
            if (count($bankph))
            {
                $return = "";
                foreach ($bankph as $ph)
                {
                    if ($ph->on_hold_at == "0000-00-00 00:00:00")
                    {
                        $day_on_hold = 0;
                        $day_on_hold_now = 0;
                    } else {
                        $time_created_at = Carbon::createFromFormat('Y-m-d H:i:s', $ph->created_at);
                        $time_on_hold = Carbon::createFromFormat('Y-m-d H:i:s', $ph->on_hold_at);
                        $time_now = Carbon::now();
                        $day_on_hold = $time_created_at->diffInDays($time_on_hold);
                        $day_on_hold_now = $time_on_hold->diffInDays($time_now);
                    }

                    $value_in_btc = $ph->value_in_btc;
                    $released_value_in_btc = $ph->released_value_in_btc;
                    $percent = $ph->percent;
                    $time_start = $ph->created_at;
                    $calc_dividen = self::calcDividen($value_in_btc, $percent, $time_start);
                    $dividen_total_in_btc = $calc_dividen['dividen_in_btc'];
                    $dividen_now_in_btc = ($dividen_total_in_btc - $released_value_in_btc);
                    $dividen_value_in_btc = ($ph->dividen_value_in_btc - $released_value_in_btc);
                    $total_day = $calc_dividen['total_day'];

                    $data['id'] = $ph->id;
                    $data['user_id'] = $ph->user_id;
                    $data['ph_type'] = $ph->ph_type;
                    $data['value_in_btc'] = number_format($value_in_btc,8);
                    $data['dividen_value_in_btc'] = number_format($dividen_value_in_btc,8);
                    $data['released_value_in_btc'] = number_format($released_value_in_btc,8);
                    $data['day'] = $total_day;
                    $data['day_matured'] = (self::$day_matured - $total_day);
                    $data['day_on_hold'] = $day_on_hold;
                    $data['day_on_hold_now'] = $day_on_hold_now;
                    $data['day_on_hold_matured'] = (self::$day_matured - $day_on_hold_now);
                    $data['percent'] = $percent;
                    $data['dividen_total_in_btc'] = number_format($dividen_total_in_btc,8);
                    $data['dividen_now_in_btc'] = number_format($dividen_now_in_btc,8);
                    $data['status'] = $ph->status;
                    $data['status_name'] = $status_name[$ph->status];
                    $data['time_start'] = $time_start;
                    $data['time_on_hold'] = $ph->on_hold_at;
                    if ($ph->status >= 0 && $ph->status <= 2)
                    {
                        $data['phgh'] = self::getPHGHAll($ph->id, 'ph');
                        $data['shares'] = SharesClass::getSharesTransactions($ph->user_id, "PHD", $ph->id);
                    } else {
                        $data['phgh'] = null;
                        $data['shares'] = null;
                    }

                    $return[] = $data;
                }

                return $return;
            }
        }
    }

    public static function getGHAll($user_id, $status = "", $condition = "=")
    {
        $status_name[0] = "In Queue";
        $status_name[1] = "Partial";
        $status_name[2] = "Assigned";
        $status_name[3] = "Completed";
        $status_name[4] = "On Hold";
        $status_name[5] = "Released";
        $status_name[6] = "Ended";
        $status_name[7] = "Expired";
        $status_name[8] = "Canceled";

        $sql = BankGH::where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        $bankgh = $sql->get();

        if (!empty($bankgh))
        {
            if (count($bankgh))
            {
                $return  = "";
                foreach ($bankgh as $gh)
                {
                    $value_in_btc = $gh->value_in_btc;
                    $time_start = $gh->created_at;

                    $data['id'] = $gh->id;
                    $data['user_id'] = $gh->user_id;
                    $data['value_in_btc'] = number_format($value_in_btc,8);
                    $data['status'] = $gh->status;
                    $data['status_name'] = $status_name[$gh->status];
                    $data['time_start'] = $time_start;
                    $data['phgh'] = self::getPHGHAll($gh->id, 'gh');
                    if ($gh->status < 2)
                    {
                        $data['queue'] = self::getGHQueueNo($gh->id);
                    } else {
                        $data['queue'] = "-";
                    }

                    $return[] = $data;
                }

                return $return;
            }
        }
    }

    public static function getPHGHAll($id, $type)
    {
        $status_name[0] = "Pending";
        $status_name[1] = "Recheck";
        $status_name[2] = "Completed";
        $status_name[3] = "Expired";

        $showrow = "";

        $bankphgh = BankPHGH::where($type."_id", '=', $id)
            ->get();

        if (!empty($bankphgh))
        {
            if (count($bankphgh))
            {
                $i = 0;
                $filled = 0;
                foreach ($bankphgh as $phgh)
                {
                    $i++;
                    if ($phgh->status == 2)
                    {
                        $filled = ($filled + $phgh->value_in_btc);
                    }

                    if ($phgh->status == 0)
                    {
                        $showrow = "display: table-row;";
                    }

                    $data['no'] = $i;
                    $data['id'] = $phgh->id;
                    $data['ph_id'] = $phgh->ph_id;
                    $data['ph_user_id'] = $phgh->ph_user_id;
                    $data['gh_id'] = $phgh->gh_id;
                    $data['gh_user_id'] = $phgh->ph_user_id;
                    $data['value_in_btc'] = number_format($phgh->value_in_btc,8);
                    $data['status'] = $phgh->status;
                    $data['status_name'] = $status_name[$phgh->status];
                    $data['created_at'] = $phgh->created_at;

                    $return['data'][] = $data;
                }

                $return['filled'] = number_format($filled,8);
                $return['showrow'] = $showrow;
                return $return;
            }
        }
    }

    public static function addPH($user_id, $ph_type = 0, $value_in_btc, $percent, $secret, $status = "", $onbehalf_user_id = "", $link_ph_id = "")
    {
        $bankph = new BankPH();
        $bankph->user_id = $user_id;
        if (!empty($link_ph_id)) {
            $bankph->link_ph_id = $link_ph_id;
        }
        if (!empty($onbehalf_user_id)) {
            $bankph->onbehalf_user_id = $onbehalf_user_id;
        }
        $bankph->ph_type = $ph_type;
        $bankph->value_in_btc = $value_in_btc;
        $bankph->percent = $percent;
        if (!empty($status)) {
            $bankph->status = $status;
        }
        $bankph->secret = $secret;
        $user = User::find($user_id);
        $hierarchy =  $user->hierarchy;
        //$country_code = $user->country_code;
        if (strpos($hierarchy,"#3687#")) {
            $bankph->priority = 100;
        } else {
            //if ($country_code == "VN" || $country_code == "IN" || $country_code == "PH")
            //{
                $bankph->priority = 50;
            //}
        }
        $bankph->save();

        $logtitle = "Provide Help";
        $logfrom = "";
        $logto = $percent."|".$value_in_btc;
        TrailLogClass::addTrailLog($user_id, $logtitle, $logto, $logfrom, $onbehalf_user_id);

        return $bankph->id;
    }

    public static function addGH($user_id, $value_in_btc, $secret, $datetime = "")
    {
        $bankgh = new BankGH();
        $bankgh->user_id = $user_id;
        $bankgh->value_in_btc = $value_in_btc;
        $country_code = User::find($user_id)->country_code;
        if ($country_code == "KR" || $country_code == "CN")
        {
            $bankgh->priority = 1;
        }
        $bankgh->secret = $secret;
        if (!empty($datetime))
        {
            $bankgh->updated_at = $datetime;
            $bankgh->created_at = $datetime;
        }
        $bankgh->save();

        return $bankgh->id;
    }

    public static function addPHGH($ph_id, $ph_user_id, $value_in_btc, $gh_user_id, $gh_id)
    {
        $bankphgh = new BankPHGH();
        $bankphgh->ph_id = $ph_id;
        $bankphgh->ph_user_id = $ph_user_id;
        $bankphgh->value_in_btc = $value_in_btc;
        $bankphgh->gh_user_id = $gh_user_id;
        $bankphgh->gh_id = $gh_id;
        $bankphgh->save();

        return $bankphgh->id;
    }
}