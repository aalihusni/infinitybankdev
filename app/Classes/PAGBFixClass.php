<?php
namespace App\Classes;

use App\User;
use App\UserClasses;
use App\Classes\EmailClass;
use App\Classes\UserClass;
use App\PAGB;
use App\PAGBFix;
use App\BitcoinBlockioWalletReceiving;
use App\ExcludeUsers;
use App\Classes\BitcoinWalletClass;
use App\Classes\BlockchainWalletClass;
use App\Classes\BlockioWalletClass;
use App\Classes\PassportClass;
use App\Classes\TrailLogClass;
use App\BitcoinBlockioWallet;
use Carbon\Carbon;
use DB;

class PAGBFixClass
{
    public static function addPAGBFix($id)
    {
        $pagb_fix = PAGBFix::where('bitcoin_wallet_receiving_id','=',$id)
            //->where('status','=',0)
            ->first();

        if (empty($pagb_fix)) {
            $blockio_receiving = BitcoinBlockioWalletReceiving::find($id);
            $pagb_fix = new PAGBFix();
            $pagb_fix->bitcoin_wallet_receiving_id = $id;
            $pagb_fix->wallet_address = $blockio_receiving->wallet_address;
            $pagb_fix->receiving_address = $blockio_receiving->receiving_address;
            $pagb_fix->value_in_btc = $blockio_receiving->value_in_btc;
            $pagb_fix->secret = BitcoinWalletClass::generateSecret();
            $pagb_fix->save();

            $logtitle = "Add PAGB Fix";
            $logfrom = "ID: " . $id . " | User ID: " . $blockio_receiving->user_id . " | Sender User ID: " . $blockio_receiving->sender_user_id;
            $logto = "Wallet Address: " . $blockio_receiving->wallet_address . " | Receiving Address: " . $blockio_receiving->receiving_address;
            TrailLogClass::addTrailLog(1, $logtitle, $logto, $logfrom);
        }
    }

    public static function getWalletAddress($user_id)
    {
        $label  = "PAGB_Fix_Wallet_1";
        $bitcoin_blockchain_wallet = BitcoinBlockioWallet::where('user_id', '=', $user_id)
            ->where('label','=',$label)
            ->first();

        if (empty($bitcoin_blockchain_wallet)) {
            $return = BlockioWalletClass::createWalletAddress($label, $user_id);

            return $return;
        }

        $return['id']               = $bitcoin_blockchain_wallet->id;
        $return['label']            = $bitcoin_blockchain_wallet->label;
        $return['wallet_address']   = $bitcoin_blockchain_wallet->wallet_address;

        return $return;
    }

    public static function processPAGBFix($id)
    {
        $pagb_fix = PAGBFix::find($id);
        $wallet_receiving_id = $pagb_fix->bitcoin_wallet_receiving_id;
        $wallet_address = $pagb_fix->wallet_address;
        $receiving_address = $pagb_fix->receiving_address;
        $value_in_btc = $pagb_fix->value_in_btc;
        $secret = $pagb_fix->secret;

        $pagbfix_wallet_address = self::getWalletAddress(1)['wallet_address'];
        $pagbfix_wallet_balance = BlockioWalletClass::getWalletBalance($pagbfix_wallet_address)['available_balance'];
        $transaction_fee = 0.0006;

        if ($pagbfix_wallet_balance >= ($value_in_btc + $transaction_fee)) {
            $pagb_fix->status = 1; // Processing
            $pagb_fix->save();

            $from_addresses = $pagbfix_wallet_address;
            $to_addresses = $wallet_address;

            $api_key = env('BLOCKIO_APP_KEY');
            $api_pin = env('BLOCKIO_APP_PIN');

            $url = "https://block.io/api/v2/withdraw_from_addresses/";

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url, [
                'http_errors' => false,
                'verify' => false,
                'query' => [
                    'api_key' => $api_key,
                    'from_addresses' => $from_addresses,
                    'to_addresses' => $to_addresses,
                    'amounts' => $value_in_btc,
                    'priority' => "high",
                    'nonce' => $secret,
                    'pin' => $api_pin
                ]
            ]);

            $raw_data = $response->getBody()->getContents();
            echo Carbon::now()." : ".$raw_data;

            if ($response->getStatusCode() == 200) {
                $response = json_decode($raw_data);
                echo Carbon::now()." : "."200<br>";
                $status = $response->status;
                if ($status == "success") {
                    echo Carbon::now()." : "."success 1<br>";
                    $data = $response->data;
                    $pagb_fix->transaction_hash = $data->txid;
                    $pagb_fix->amount_withdrawn = $data->amount_withdrawn;
                    $pagb_fix->amount_sent = $data->amount_sent;
                    $pagb_fix->network_fee = $data->network_fee;
                    $pagb_fix->raw_data = $raw_data;
                    $pagb_fix->status = 4; // Success
                    $pagb_fix->save();
                    echo Carbon::now()." : "."success 2<br>";
                    $blockio_receiving = BitcoinBlockioWalletReceiving::find($wallet_receiving_id);
                    $blockio_receiving->status = 1;
                    $blockio_receiving->save();
                    echo Carbon::now()." : "."success 3<br>";
                    //$return['bitcoin_blockio_withdraw_id'] = $bitcoin_blockio_withdraw->id;
                    $return['transaction_hash'] = $data->txid;
                    $return['amount_withdrawn'] = $data->amount_withdrawn;
                    $return['amount_sent'] = $data->amount_sent;
                    $return['network_fee'] = $data->network_fee;
                    $return['raw_data'] = $raw_data;
                    echo Carbon::now()." : "."success 4<br>";
                    //return $return;
                } else {
                    $pagb_fix->status = 3; // Error/Fail
                    $pagb_fix->save();
                }
            } else {
                $pagb_fix->status = 2; // Error/Fail
                $pagb_fix->save();
            }

            $pagb_fix->raw_data = $raw_data;
            $pagb_fix->save();
            //return false;
        } else {
            echo Carbon::now()." : "."Not enough fund !<br>";
        }
    }

    public static function getPAGBFix()
    {
        echo Carbon::now()." : ### Starting PAGB FIX";

        $pagbfix_wallet_address = self::getWalletAddress(1)['wallet_address'];
        $pagbfix_wallet_balance = BlockioWalletClass::getWalletBalance($pagbfix_wallet_address);

        //echo $pagbfix_wallet_address."<br>";
        echo Carbon::now()." : "."PE ".$pagbfix_wallet_balance['pending_received_balance']."<br>";
        echo Carbon::now()." : "."AV ".$pagbfix_wallet_balance['available_balance']."<br>";
        $pagbfix_wallet_balance = $pagbfix_wallet_balance['available_balance'];


        if ($pagbfix_wallet_balance > 0) {

            $pagb_fix = PAGBFix::where('status', '=', 0)
                ->orderby('id')
                ->get();

            echo Carbon::now()." : ".count($pagb_fix)." records found.<br>";

            if (!empty($pagb_fix)) {
                if (count($pagb_fix)) {
                    foreach ($pagb_fix as $pagbfix) {
                        echo Carbon::now()." : "."Processing ".$pagbfix->id."<br>";
                        self::processPAGBFix($pagbfix->id);
                    }
                }
            }
        }
    }
}
