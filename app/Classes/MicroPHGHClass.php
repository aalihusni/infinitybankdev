<?php
namespace App\Classes;

use App\MicroBankPH;
use App\MicroBankGH;
use App\MicroBankPHGH;
use App\Settings;
use App\Classes\MicroSharesClass;
use App\User;
use DB;
use Carbon\Carbon;
use App\Classes\MicroPassportClass;
use App\Classes\BlockioWalletClass;

class MicroPHGHClass
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
     */

    /*
     * #PHGH
     * 0 = pending
     * 1 = waiting confirmation
     * 2 = confirmed / completed
     * 3 = expired
     */

    public static $day_queue = 2; //How many days to queue PH & GH before assign
    public static $day_assigned_expiry = 1; //How many days after assigned to expired
    public static $day_matured = 20; //How many days for on hold & active ph to matured
    public static $expired_limit = 3; //How many expired per ph before ended

    //==================================================
    // Payment

    //Get PH Payment Details
    public static function getPHPaymentDetails($phgh_id)
    {
        $phgh = self::getPHGH($phgh_id);
        $sender_user_id = $phgh['ph_user_id'];
        $receiver_user_id = $phgh['gh_user_id'];
        $value_in_btc = $phgh['value_in_btc'];

        $receiving_address = BlockioWalletClass::getReceivingAddressUser($receiver_user_id, $sender_user_id, "MPH", $value_in_btc, $phgh_id)['receiving_address'];

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
        $bankph = MicroBankPH::find($ph_id);

        if ($bankph->status == 4)
        {
            $date_on_hold = Carbon::createFromFormat('Y-m-d H:i:s', $bankph->on_hold_at);
            $date_now = Carbon::now();
            $total_day = $date_on_hold->diffInDays($date_now);

            if ($total_day >= $day_matured)
            {
                DB::beginTransaction();

                echo "Pledge PH Matured (Process)<br>";
                $status = 6; //Ended
                $ph_id = $bankph->id;
                $value_in_btc = $bankph->dividen_value_in_btc;

                self::releasePHProfit($ph_id, $value_in_btc);

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
            $bankph = MicroBankPH::find($ph_id);

            if (!empty($bankph)) {
                if (count($bankph)) {
                    DB::beginTransaction();

                    $status = 4; //On Hold
                    $bankph->status = $status;
                    $bankph->dividen_value_in_btc = $ph['dividen_total_in_btc'];
                    $bankph->on_hold_at = Carbon::now();

                    $status = 3; //Active
                    $user_id = $bankph->user_id;
                    $ph_type = 1; //Completed Pledge PH @ Active PH
                    $value_in_btc = $bankph->value_in_btc;

                    $link_ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $status, "", $ph_id);

                    $bankph->link_ph_id = $link_ph_id;
                    $bankph->save();

                    /*
                     * Give Bonus
                     */
                    //self::addPHBonus($user_id, $ph_id, $value_in_btc);

                    DB::commit();
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
            $bankph = MicroBankPH::find($ph_id);

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

                            $link_ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $status, "", $ph_id);

                            $bankph->link_ph_id = $link_ph_id;
                            $bankph->save();

                            /*
                            * Give Bonus
                            */
                            //self::addPHBonus($user_id, $ph_id, $value_in_btc);
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
        $bankgh = MicroBankGH::where('status', '=', '2')
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
                        echo "GH Completed : ".$gh_id."<br>";
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
        $bankph = MicroBankPH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `on_hold_at`,"'.Carbon::now().'") as day_on_hold'))
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
                            echo "Pledge PH Completed : ".$ph_id."<br>";
                            self::pledgePHCompleted($ph_id, $percent);
                        }
                    }

                    if ($ph->status == 4) {
                        //Pledge Matured
                        if ($ph->day_on_hold >= 20) {
                            echo "Pledge PH Matured : ".$ph_id."<br>";
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
        $bankph = MicroBankPH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `on_hold_at`,"'.Carbon::now().'") as day_on_hold'))
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

                    if ($ph->expired >= self::$expired_limit) {
                        //Pledge Expired
                        echo "Pledge PH Expired : ".$ph_id."<br>";
                        self::pledgePHExpired($ph_id);
                    }
                }
            }
        }

        return true;
    }

    //Check All PHGH Payment Status Is Completed
    public static function  getPHGHPaymentStatusAll($type, $id)
    {
        $sql = MicroBankPHGH::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '") as day_assigned'));
        if ($type == "ph") {
            $sql->where('ph_id', '=', $id);
        } else {
            $sql->where('gh_id', '=', $id);
        }
        $bankphgh = $sql->where('status', '<', '3')
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
                            echo "PHGH ".$phgh->id." Expired"."<br>";

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
                        $return = false;
                    }
                    elseif ($phgh->status == 1) // Waiting
                    {
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

    public static function releasePH($ph_type, $ph_id, $value_in_btc = 0)
    {
        DB::beginTransaction();

        if ($ph_type == "profit") {
            self::releasePHProfit($ph_id, $value_in_btc);
        } else {
            self::releasePHAll($ph_id);
        }

        DB::commit();
    }

    public static function releasePHAll($ph_id)
    {
        $percent = "";
        $shares_type_id = $ph_id;
        $ph = self::getPH($ph_id);
        $user_id = $ph['user_id'];

        //Micro PH
        $shares_type = "MPHC";
        MicroSharesClass::setShares($user_id, $shares_type, $shares_type_id, $user_id, $percent, $ph['value_in_btc']);

        //Micro PH Dividen
        $shares_type = "MPHD";
        MicroSharesClass::setShares($user_id, $shares_type, $shares_type_id, $user_id, $percent, $ph['dividen_now_in_btc']);


        //Update Micro PH
        $status = 6; // Ended
        self::setPH($ph_id, $status, $ph['dividen_now_in_btc'], $ph['dividen_total_in_btc']);
    }

    public static function releasePHProfit($ph_id, $value_in_btc = 0)
    {
        $percent = "";
        $shares_type_id = $ph_id;
        $ph = self::getPH($ph_id);
        $user_id = $ph['user_id'];

        //Micro PH Dividen
        $shares_type = "MPHD";
        MicroSharesClass::setShares($user_id, $shares_type, $shares_type_id, $user_id, $percent, $value_in_btc);

        //Update Micro PH
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

        echo "PH Count : ".$ph_count."<br>";
        echo "GH Count : ".$gh_count."<br>";
        if ($ph_count && $gh_count)
        {
            //Get list of PH
            $ph_list = self::getQueuePHList($priority, $now);

            echo "PH List : ".count($ph_list)."<br>";

            //Try to match all Queue PH
            foreach ($ph_list as $ph)
            {
                //Get PH balance value
                $ph_id = $ph->id;
                $ph_user_id = $ph->user_id;
                $ph_value = $ph->value_in_btc;
                $ph_assigned = self::getAssignedPHValue($ph->id);
                $ph_balance = $ph_value - $ph_assigned;

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

                            echo "GH List : ".count($gh_list)."<br>";

                            //Try to match all Queue GH
                            foreach ($gh_list as $gh) {
                                //If shares balance below zero skip GH
                                $shares_balance = MicroSharesClass::getSharesBalance($gh->user_id)['shares_balance'];

                                if ($shares_balance >= 0) {
                                    //Get GH balance value
                                    $gh_id = $gh->id;
                                    $gh_user_id = $gh->user_id;
                                    $gh_value = $gh->value_in_btc;
                                    $gh_assigned = self::getAssignedGHValue($gh->id);
                                    $gh_balance = $gh_value - $gh_assigned;

                                    //Check if GH balance above 0
                                    if ($gh_balance > 0) {

                                        if ($ph_balance > $gh_balance) {
                                            echo "use gh" . "<br>";
                                            //If PH is higher use GH balance
                                            $value_in_btc = $gh_balance;

                                            //Deduct PH & GH balance
                                            $ph_balance = ($ph_balance - $gh_balance);
                                            $gh_balance = ($gh_balance - $gh_balance);
                                        } elseif ($ph_balance < $gh_balance) {
                                            echo "use ph" . "<br>";
                                            //If GH is higher use PH balance
                                            $value_in_btc = $ph_balance;

                                            //Deduct PH & GH balance
                                            $ph_balance = ($ph_balance - $ph_balance);
                                            $gh_balance = ($gh_balance - $ph_balance);
                                        } else {
                                            echo "use both" . "<br>";
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

                                        echo $gh_balance . "<br>";
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
                                        echo "gh status = " . $status . "<br>";

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
                                        echo $gh->id . " This GH fully assigned<br>";

                                        //This GH fully assigned.
                                        $status = 2;
                                        $gh->status = $status;
                                        $gh->save();
                                    }
                                }
                            }
                            DB::commit();
                        } else {
                            DB::commit();

                            //No GH Queue. Exit ph_list foreach
                            break 1;
                        }
                    } else {
                        echo $ph->id . " This PH fully assigned<br>";

                        //This PH fully assigned.
                        $status = 2;
                        $ph->status = $status;
                        $ph->save();

                        DB::commit();
                    }
                } else {
                    if ($ph_balance == 0) {
                        echo $ph->id . " This PH fully assigned<br>";

                        //This PH fully assigned.
                        $status = 2;
                        $ph->status = $status;
                        $ph->save();

                        DB::commit();
                    }
                }
            }
        }

        return false;
    }

    public static function getAssignedPHPaidValue($ph_id)
    {
        $ph = MicroBankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '=', '2')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedPHPendingValue($ph_id)
    {
        $ph = MicroBankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '=', '0')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedPHValue($ph_id)
    {
        $ph = MicroBankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
            ->where('ph_id', '=', $ph_id)
            ->where('status', '<', '3')
            ->first();
        $value_in_btc = $ph->value_in_btc;

        return $value_in_btc;
    }

    public static function getAssignedGHValue($gh_id)
    {
        $gh = MicroBankPHGH::select(DB::raw('sum(value_in_btc) as value_in_btc'))
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
            $ph_list = MicroBankPH::where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->get();
        } else {
            $ph_list = MicroBankPH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '")'), '>=', $day_queue)
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

        $gh_list = MicroBankGH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"'.Carbon::now().'")'), '>=', $day_queue)
            ->where('status', '<', '2')
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
            $ph_count = MicroBankPH::where('status', '<', '2')
                ->where('priority', '=', $priority)
                ->orderby('created_at', 'asc')
                ->orderby('id', 'asc')
                ->count();
        } else {
            $ph_count = MicroBankPH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"' . Carbon::now() . '")'), '>=', $day_queue)
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

        $gh_count = MicroBankGH::where(DB::raw('TIMESTAMPDIFF(DAY, `created_at`,"'.Carbon::now().'")'), '>=', $day_queue)
            ->where('status', '<', '2')
            ->orderby('priority', 'desc')
            ->orderby('created_at', 'asc')
            ->orderby('id', 'asc')
            ->count();

        return $gh_count;
    }

    //==================================================
    // Database

    public static function createPH($user_id, $value_in_btc, $type, $onbehalf_user_id = "")
    {
        DB::beginTransaction();
        $status = null;

        //Passport
        if (empty($onbehalf_user_id)) {

            $passport_balance = MicroPassportClass::getPassportBalance($user_id);
            $error['error'] = "Insufficient micro passport balance. Please purchase micro passport!";
            $error['redirect'] = "micro-passport";
            if ($passport_balance == 0) return $error;

            $passport_id = MicroPassportClass::setPassportBalance($user_id, -1, "MPH");
            //MicroPassportClass::addPassportBonus($user_id, $passport_id);
        } else {
            $passport_balance = MicroPassportClass::getPassportBalance($onbehalf_user_id);
            $error['error'] = "Insufficient micro passport balance. Please purchase micro passport!";
            $error['redirect'] = "micro-passport";
            if ($passport_balance == 0) return $error;

            $passport_id = MicroPassportClass::setPassportBalance($onbehalf_user_id, -1, "MPH");
            //MicroPassportClass::addPassportBonus($user_id, $passport_id);
        }

        $percent = PHGHClass::getPercent($type);
        if ($type == "active") {
            $status = 3;
            $ph_type = 1;
        } else {
            $ph_type = 0;
        }

        $ph_id = self::addPH($user_id, $ph_type, $value_in_btc, $percent, $status, $onbehalf_user_id);
        DB::commit();

        return $ph_id;
    }

    public static function createGH($user_id, $value_in_btc)
    {
        $passport_balance = MicroPassportClass::getPassportBalance($user_id);
        $error['error'] = "Insufficient micro passport balance. Please purchase micro passport!";
        $error['redirect'] = "micro-passport";
        if ($passport_balance == 0) return $error;

        $passport_id = MicroPassportClass::setPassportBalance($user_id, -1, "MGH");
        //MicroPassportClass::addPassportBonus($user_id, $passport_id);

        return self::addGH($user_id, $value_in_btc);
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
                $bonus_total = MicroSharesClass::getPHBonusPerUser($upline_user_id, $user_id);
                if ($bonus_total < $bonus_limit) {
                    $percent_value_in_btc = (($value_in_btc / 100) * $percent);
                    if (($bonus_total + $percent_value_in_btc) >= 3)
                    {
                        $percent_value_in_btc = ($bonus_limit - $bonus_total);
                    }

                    $status = 1;
                    MicroSharesClass::setShares($upline_user_id, $shares_type, $shares_type_id, $user_id, $percent, $percent_value_in_btc);
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

        $return['dividen_day_in_satoshi'] = $dividen_day_in_satoshi;
        $return['dividen_day_in_btc'] = $dividen_day_in_btc;
        $return['dividen_second_in_satoshi'] = $dividen_second_in_satoshi;
        $return['dividen_second_in_btc'] = $dividen_second_in_btc;
        $return['total_sec'] = $total_sec;
        $return['total_min'] = $total_min;
        $return['total_hour'] = $total_hour;
        $return['total_day'] = $total_day;
        $return['dividen_in_satoshi'] = $dividen_in_satoshi;
        $return['dividen_in_btc'] = $dividen_in_btc;

        return $return;
    }

    public static function getTotalActiveDividen($user_id, $status = "", $condition = "=")
    {
        $total_active_ph = 0;
        $total_active_dividen = 0;
        $total_second_dividen = 0;
        $total_second_dividen_satoshi = 0;
        $total_released_dividen = 0;

        $sql = MicroBankPH::where('user_id', '=', $user_id);
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

    public static function getPHTotal($user_id, $status = "", $condition = "=")
    {
        $sql = MicroBankPH::select(DB::raw('sum(value_in_btc) as total'))
            ->where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        $bankph = $sql->first();

        $total = $bankph->total;
        $balance = (0.5 - $total);

        $return['active'] = number_format($total,8);
        $return['balance'] = number_format($balance,8);

        return $return;
    }

    public static function getGHTotal($user_id, $status = "", $condition = "=")
    {
        $sql = MicroBankGH::select(DB::raw('sum(value_in_btc) as total'))
            ->where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
        }
        $bankgh = $sql->first();

        $total = $bankgh->total;
        $balance = (0.5 - $total);

        $return['active'] = number_format($total,8);
        $return['balance'] = number_format($balance,8);

        return $return;
    }

    /*
    public static function getPHGHAllTotal($type, $type_id, $status)
    {
        $bankphgh = MicroBankPHGH::select(DB::raw('sum(value_in_btc) as total'))
            ->where($type."_id", '=', $type_id)
            ->where('status', '=', $status)
            ->first();

        $total = $bankphgh->total;

        return $total;
    }
    */
    public static function setPHExpired($ph_id)
    {
        $bankph = MicroBankPH::find($ph_id);
        $bankph->expired = ($bankph->expired + 1);
        $bankph->save();

        return $bankph->expired;
    }

    public static function setPH($ph_id, $status = 0, $released_value_in_btc = 0, $dividen_value_in_btc = 0)
    {
        $bankph = MicroBankPH::find($ph_id);
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
        $bankgh = MicroBankGH::find($gh_id);
        $bankgh->status = $status;
        $bankgh->save();
    }

    public static function setPHGH($phgh_id, $status)
    {
        $bankphgh = MicroBankPHGH::find($phgh_id);
        $bankphgh->status = $status;
        $bankphgh->save();
    }

    /*
    public static function getAllPH($status = "", $condition = "=")
    {
        if (!empty($status)) {
            $bankph = MicroBankPH::where('status', $condition, $status)
                ->get();
        } else {
            $bankph = MicroBankPH::get();
        }

        return $bankph;
    }

    public static function getAllGH($status = "", $condition = "=")
    {
        if (!empty($status)) {
            $bankgh = MicroBankGH::where('status', $condition, $status)
                ->get();
        } else {
            $bankgh = MicroBankGH::get();
        }

        return $bankgh;
    }
    */

    public static function getGHQueueNo($gh_id)
    {
        $bankgh = MicroBankGH::where('id', '<=', $gh_id)
            ->where('status', '<', 2)
            ->orderby('created_at', 'asc')
            ->count();

        $bankgh = ($bankgh + 100);
        return $bankgh;
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

        $bankph = MicroBankPH::find($ph_id);
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
                $data['shares'] = MicroSharesClass::getSharesTransactions($ph->user_id, "MPHD", $ph->id);
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

        $bankgh = MicroBankGH::find($ph_id);

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
        $status_name[1] = "Waiting";
        $status_name[2] = "Completed";
        $status_name[3] = "Expired";

        $bankphgh = MicroBankPHGH::find($id);

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

    public static function getPHAll($user_id, $status = "", $condition = "=")
    {
        $status_name[0] = "In Queue";
        $status_name[1] = "Partial";
        $status_name[2] = "Assigned";
        $status_name[3] = "Active";
        $status_name[4] = "On Hold";
        $status_name[5] = "Released";
        $status_name[6] = "Ended";
        $status_name[7] = "Expired";

        $sql = MicroBankPH::where('user_id', '=', $user_id);
        if (!empty($status)) {
            $sql->where('status', $condition, $status);
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
                    $data['phgh'] = self::getPHGHAll($ph->id, 'ph');
                    $data['shares'] = MicroSharesClass::getSharesTransactions($ph->user_id, "MPHD", $ph->id);

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

        $sql = MicroBankGH::where('user_id', '=', $user_id);
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
        $status_name[1] = "Waiting";
        $status_name[2] = "Completed";
        $status_name[3] = "Expired";

        $showrow = "";

        $bankphgh = MicroBankPHGH::where($type."_id", '=', $id)
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

    public static function addPH($user_id, $ph_type = 0, $value_in_btc, $percent, $status = "", $onbehalf_user_id = "", $link_ph_id = "")
    {
        $bankph = new MicroBankPH();
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

    public static function addGH($user_id, $value_in_btc)
    {
        $bankgh = new MicroBankGH();
        $bankgh->user_id = $user_id;
        $bankgh->value_in_btc = $value_in_btc;
        $country_code = User::find($user_id)->country_code;
        if ($country_code == "VN" || $country_code == "IN" || $country_code == "PH")
        {
            $bankgh->priority = 1;
        }
        $bankgh->save();

        return $bankgh->id;
    }

    public static function addPHGH($ph_id, $ph_user_id, $value_in_btc, $gh_user_id, $gh_id)
    {
        $bankphgh = new MicroBankPHGH();
        $bankphgh->ph_id = $ph_id;
        $bankphgh->ph_user_id = $ph_user_id;
        $bankphgh->value_in_btc = $value_in_btc;
        $bankphgh->gh_user_id = $gh_user_id;
        $bankphgh->gh_id = $gh_id;
        $bankphgh->save();

        return $bankphgh->id;
    }
}