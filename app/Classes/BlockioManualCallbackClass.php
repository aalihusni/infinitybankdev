<?php
namespace App\Classes;

use App\Classes\BlockioWalletClass;
use App\Classes\BlockioCallbackClass;
use App\BitcoinBlockioWalletReceiving;
use App\BankPHGH;
use App\Classes\TrailLogClass;
use DB;
use Carbon\Carbon;

class BlockioManualCallbackClass
{
    //public static $api_key = "147f-4377-dcc4-aa98"; //Mainnet
    //public static $api_pin = "br828385br";

    public static function manual_callback()
    {
        $sys_status = env('SYS_STATUS', 0);

        if ($sys_status == 1)
        {
            $wallet_receiving = BitcoinBlockioWalletReceiving::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"' . Carbon::now() . '") as min_assigned'))
                ->where('status', '<', '2')
                ->where('payment_type', '<>', 'PA')
                ->orderby('created_at', 'asc')
                ->get();
        }
        elseif ($sys_status == 2)
        {
            $wallet_receiving = BitcoinBlockioWalletReceiving::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"' . Carbon::now() . '") as min_assigned'))
                ->where('status', '<', '2')
                ->where('payment_type', '=', 'PA')
                ->orderby('created_at', 'asc')
                ->get();
        } else {
            $wallet_receiving = BitcoinBlockioWalletReceiving::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"' . Carbon::now() . '") as min_assigned'))
                ->where('status', '<', '2')
                ->orderby('created_at', 'asc')
                ->get();
        }
        if (!empty($wallet_receiving))
        {
            if (count($wallet_receiving))
            {
                echo Carbon::now()." : ".count($wallet_receiving)." Records Found<br>"."<br>\r\n";

                foreach ($wallet_receiving as $pending)
                {
                    $user_id = $pending->user_id;
                    $payment_type = $pending->payment_type;
                    $secret = $pending->secret;
                    $receiving_address = $pending->receiving_address;
                    $min_assigned = $pending->min_assigned;

                    echo Carbon::now()." : "."Processing ".$payment_type." | ".$pending->id." | ".$secret." | ".$receiving_address." | ".$min_assigned."<br>\r\n";

                    if (self::checkStatus($pending->id) < 2)
                    {
                        echo Carbon::now()." : "."##<br>receiving_address:".$receiving_address."|secret:".$secret."<br>\r\n";
                        $wallet_transactions = self::getWalletTransactions($receiving_address, $secret);
                        echo Carbon::now()." : "."##<br>\r\n";
                    }
                    if (($pending->payment_type == "PA" && $min_assigned >= 65) ||
                        ($pending->payment_type <> "PA" && $min_assigned >= 15))
                    {
                        if (self::checkStatus($pending->id) == 0)
                        {
                            $pending->status = 3;
                            $pending->save();

                            TrailLogClass::addTrailLog($user_id, "Receiving Address Expired", $receiving_address, $payment_type);
                        }
                    }
                }
            }
        }
    }

    public static function single_manual_callback($receiving_address)
    {
        $sys_status = env('SYS_STATUS', 0);
        $wallet_receiving = BitcoinBlockioWalletReceiving::select(DB::raw('*'), DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"' . Carbon::now() . '") as min_assigned'))
            ->where('receiving_address', '=', $receiving_address)
            ->where('status', '<', '2')
            ->orderby('created_at', 'desc')
            ->first();
        if (!empty($wallet_receiving))
        {
            if (count($wallet_receiving))
            {
                echo Carbon::now()." : ".count($wallet_receiving)." Records Found<br>\r\n";

                $pending = $wallet_receiving;

                $user_id = $pending->user_id;
                $payment_type = $pending->payment_type;
                $secret = $pending->secret;
                $receiving_address = $pending->receiving_address;
                $min_assigned = $pending->min_assigned;

                if ($sys_status < 2 && $payment_type <> "PA")
                {
                    echo Carbon::now()." : "."Processing ".$pending->id." | ".$secret." | ".$receiving_address." | ".$min_assigned."<br>\r\n";

                    if (self::checkStatus($pending->id) < 2)
                    {
                        echo Carbon::now()." : "."##<br>receiving_address:".$receiving_address."|secret:".$secret."<br>\r\n";
                        $wallet_transactions = self::getWalletTransactions($receiving_address, $secret, "Manual Single");
                        echo Carbon::now()." : "."##<br>\r\n";
                    }
                    if (($pending->payment_type == "PA" && $min_assigned >= 65) ||
                        ($pending->payment_type <> "PA" && $min_assigned >= 15))
                    {
                        if (self::checkStatus($pending->id) == 0)
                        {
                            $pending->status = 3;
                            $pending->save();

                            TrailLogClass::addTrailLog($user_id, "Receiving Address Expired", $receiving_address, $payment_type);
                        }
                    }
                }
            }
        }
    }

    public static function checkStatus($id)
    {
        return BitcoinBlockioWalletReceiving::find($id)->status;
    }

    public static function getWalletTransactions($receiving_address, $secret, $type = "",  $value_in_btc = "")
    {
        $url = "https://block.io/api/v2/get_transactions/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY'),
                'type'      => "received",
                'addresses' => $receiving_address
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;
            if ($status == "success") {
                $data                           = $response->data;
                $data_network                   = $data->network;
                $data_txs                       = $data->txs;

                foreach ($data_txs as $txs)
                {
                    foreach($txs->senders as $txs_senders) {
                        $sender_address = $txs_senders;
                    }
                    $data_txid = $txs->txid;
                    $data_address = $receiving_address;
                    $data_amount_sent = ""; //empty
                    foreach($txs->amounts_received as $txs_amounts_received) {
                        $data_amount_received = $txs_amounts_received->amount;
                    }
                    $data_confirmations = $txs->confirmations;
                    $secret = $secret;
                    $referer_url = "";
                    $client_ip = "127.0.0.1";
                    $notification_id = "";
                    $notification_delivery_attempt = "0";
                    if (empty($type)) {
                        $notification_type = "Manual";
                    } else {
                        $notification_type = $type;
                    }
                    $notification_data = "";
                    $notification_created_at = "";
                    $notification_raw_data  = json_encode($data);

                    echo Carbon::now()." : "."sender_address :" . $sender_address."<br>\r\n";
                    echo Carbon::now()." : "."data_txid :" . $data_txid."<br>\r\n";
                    echo Carbon::now()." : "."data_address :" . $data_address."<br>\r\n";
                    echo Carbon::now()." : "."data_amount_sent :" . $data_amount_sent."<br>\r\n";
                    echo Carbon::now()." : "."data_amount_received :" . $data_amount_received."<br>\r\n";
                    echo Carbon::now()." : "."data_confirmations :" . $data_confirmations."<br>\r\n";

                    //Reset wallet receiving status to 1 if full payment received.
                    if (!empty($value_in_btc))
                    {
                        if ($data_amount_received >= $value_in_btc)
                        {
                            $wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address','=', $receiving_address)
                                ->where('payment_type','=','PH')
                                ->orderby('id','desc')
                                ->first();
                            if(!empty($wallet_receiving))
                            {
                                if (count($wallet_receiving))
                                {
                                    if($wallet_receiving->status == 3)
                                    {
                                        $wallet_receiving->status = 1;
                                        $wallet_receiving->save();
                                        echo Carbon::now()." : "."Reset Wallet Receiving Status - ID: ".$wallet_receiving->id." | PHGH: ".$wallet_receiving->payment_specific." | Receiving Address: ".$receiving_address."<br>\r\n";
                                    }
                                }
                            }
                        }
                    }
                    BlockioCallbackClass::setCallback($sender_address, $data_txid, $data_address, $data_amount_sent, $data_amount_received, $data_confirmations, $secret, $referer_url, $client_ip, $notification_id, $notification_delivery_attempt, $notification_type, $notification_data, $notification_created_at, $notification_raw_data);
                }

                return true;
            }

            return false;
        } else {
            return false;
        }
    }

    public static function recheckOnholdPHGH()
    {
        echo Carbon::now()." : "."### Recheck Onhold PHGH - Start<br>\r\n";

        $bank_phgh = BankPHGH::where('status','=','1')
            ->orderby('id','desc')
            ->get();
        if (!empty($bank_phgh))
        {
            if ($bank_phgh)
            {
                echo Carbon::now()." : ".count($bank_phgh)." Records Found<br>\r\n";

                foreach ($bank_phgh as $phgh)
                {
                    $wallet_receiving = BitcoinBlockioWalletReceiving::where('payment_type','=','PH')
                        ->where('payment_specific','=',$phgh->id)
                        ->orderby('id','desc')
                        ->get();

                    echo Carbon::now()." : ".count($wallet_receiving)." Addresses Found<br>\r\n";

                    if (!empty($wallet_receiving))
                    {
                        if (count($wallet_receiving))
                        {
                            $i=0;
                            foreach ($wallet_receiving as $wallet)
                            {
                                $i++;
                                $pending = $wallet;

                                $user_id = $pending->user_id;
                                $payment_type = $pending->payment_type;
                                $secret = $pending->secret;
                                $receiving_address = $pending->receiving_address;
                                $min_assigned = $pending->min_assigned;
                                $value_in_btc = $pending->value_in_btc;

                                echo Carbon::now()." : "."Processing Recheck (".$i.") ".$payment_type." | ".$pending->id." | ".$secret." | ".$receiving_address." | ".$min_assigned."<br>\r\n";

                                if (self::checkStatus($pending->id) <> 2)
                                {
                                    echo Carbon::now()." : "."##<br>receiving_address:".$receiving_address."|secret:".$secret."<br>\r\n";
                                    $wallet_transactions = self::getWalletTransactions($receiving_address, $secret, "Manual Single", $value_in_btc);
                                    echo Carbon::now()." : "."##<br>\r\n";

                                    if ($wallet_transactions && (self::checkStatus($pending->id) == 2))
                                    {
                                        echo Carbon::now()." : ".$phgh->id." PHGH Recheck Processed (".$i.")<br>\r\n";
                                        TrailLogClass::addTrailLog($phgh->ph_user_id, "PHGH Recheck Processed (".$i.")", $phgh->id, $payment_type);
                                        TrailLogClass::addTrailLog($phgh->gh_user_id, "PHGH Recheck Processed (".$i.")", $phgh->id, $payment_type);
                                    }
                                }
                            }
                        } else {
                            echo Carbon::now() . " : " . "PHGH " . $phgh->id . " Revert" . "<br>\r\n";

                            $status = 0; // Pending
                            $phgh->status = $status;
                            $phgh->save();
                        }
                    } else {
                        echo Carbon::now() . " : " . "PHGH " . $phgh->id . " Revert" . "<br>\r\n";

                        $status = 0; // Pending
                        $phgh->status = $status;
                        $phgh->save();
                    }
                }
            }
        }
        echo Carbon::now()." : "."### Recheck Onhold PHGH - Finish<br>\r\n";
    }
}