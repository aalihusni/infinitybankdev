<?php
namespace App\Classes;

use App\BitcoinBlockioWallet;
use App\BitcoinBlockioWalletReceiving;
use App\BitcoinBlockioWithdraw;
use App\BitcoinBlockioApiHistory;
use App\Classes\BitcoinWalletClass;
use App\Classes\BlockioCallbackProcessLogClass;
use App\User;
use Validator;
use DB;
use Carbon\Carbon;

class BlockioWalletClass
{
    //public static env('BLOCKIO_APP_KEY') = "4968-4f3f-179a-5a4b"; //Testnet
    //public static $api_key = env('BLOCKIO_APP_KEY'); //"147f-4377-dcc4-aa98"; //Mainnet
    //public static $api_pin = env('BLOCKIO_APP_PIN'); //"cat919496walk";
    public static $callback_url = "https://www.bitregion.co/blockio-callback?secret=";

    public static function addApiHistory($status, $data, $user_id = "", $sender_user_id = "")
    {
        $history = new BitcoinBlockioApiHistory();
        $history->status = $status;
        $history->data = json_encode($data);
        if (!empty($user_id))
        {
            $history->user_id = $user_id;
        }
        if (!empty($sender_user_id))
        {
            $history->sender_user_id = $sender_user_id;
        }
        $history->save();
    }

    public static function getWaitingConfirmations($sender_user_id, $payment_type)
    {
        $waiting_confirmations = BitcoinBlockioWalletReceiving::where('sender_user_id', '=', $sender_user_id)
            ->where('payment_type' ,'=', $payment_type)
            ->where('status' ,'=', '1')
            ->get();

        if (!empty($waiting_confirmations)) {
            if (count($waiting_confirmations)) {
                return $waiting_confirmations;
            }
        }

        return false;
    }

    public static function getEstimateNetworkFee($to_addresses, $value_in_btc)
    {
        $url = "https://block.io/api/v2/get_network_fee_estimate/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'       => env('BLOCKIO_APP_KEY'),
                'to_addresses'  => $to_addresses,
                'amounts'       => $value_in_btc
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;
            if ($status == "success") {
                $data = $response->data;
                $estimated_network_fee = $data->estimated_network_fee;

                return $estimated_network_fee;
            }
        }

        return false;
    }

    public static function withdraw($bitcoin_wallet_receiving_id, $user_id, $from_addresses, $to_addresses, $value_in_btc, $secret)
    {
        $bitcoin_blockio_withdraw = new BitcoinBlockioWithdraw();
        $bitcoin_blockio_withdraw->bitcoin_wallet_receiving_id = $bitcoin_wallet_receiving_id;
        $bitcoin_blockio_withdraw->user_id = $user_id;
        $bitcoin_blockio_withdraw->from_addresses = $from_addresses;
        $bitcoin_blockio_withdraw->to_addresses = $to_addresses;
        $bitcoin_blockio_withdraw->value_in_btc = $value_in_btc;
        $bitcoin_blockio_withdraw->secret = $secret;
        $bitcoin_blockio_withdraw->save();

        $url = "https://block.io/api/v2/withdraw_from_addresses/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'       => env('BLOCKIO_APP_KEY'),
                'from_addresses'  => $from_addresses,
                'to_addresses'  => $to_addresses,
                'amounts'       => $value_in_btc,
                'priority'       => "high",
                'nonce'       => $secret,
                'pin'       => env('BLOCKIO_APP_PIN')
            ]
        ]);

        $raw_data = $response->getBody()->getContents();
        echo $raw_data;

        if ($response->getStatusCode() == 200) {
            $response = json_decode($raw_data);
            echo "200<br>";
            $status = $response->status;
            if ($status == "success") {
                echo "success<br>";
                $data = $response->data;
                $bitcoin_blockio_withdraw->transaction_hash = $data->txid;
                $bitcoin_blockio_withdraw->amount_withdrawn = $data->amount_withdrawn;
                $bitcoin_blockio_withdraw->amount_sent = $data->amount_sent;
                $bitcoin_blockio_withdraw->network_fee = $data->network_fee;
                $bitcoin_blockio_withdraw->raw_data = $raw_data;
                $bitcoin_blockio_withdraw->save();

                $return['bitcoin_blockio_withdraw_id'] = $bitcoin_blockio_withdraw->id;
                $return['transaction_hash'] = $data->txid;
                $return['amount_withdrawn'] = $data->amount_withdrawn;
                $return['amount_sent'] = $data->amount_sent;
                $return['network_fee'] = $data->network_fee;
                $return['raw_data'] = $raw_data;

                return $return;
            }
        }

        $bitcoin_blockio_withdraw->raw_data = $raw_data;
        $bitcoin_blockio_withdraw->save();
        return false;
    }

    public static function getTransactionConfirmations($receiving_address, $transaction_hash)
    {
        $transaction_confirmations = self::getTransactionDetails($receiving_address, $transaction_hash);

        if ($transaction_confirmations)
        {
            $confirmations              = $transaction_confirmations['confirmations'];
            $senders_address            = $transaction_confirmations['senders'];

            $wallet_receiving_details   = self::getWalletReceivingDetails($receiving_address);
            $sender_user_id             = $wallet_receiving_details['sender_user_id'];
            $payment_type               = $wallet_receiving_details['payment_type'];
            $payment_specific           = $wallet_receiving_details['payment_specific'];
            $status                     = $wallet_receiving_details['status'];
            $value_in_btc               = $wallet_receiving_details['value_in_btc'];
            $wallet_address             = $wallet_receiving_details['wallet_address'];
            $wallet_balance             = self::getWalletBalance($wallet_address);
            if ($wallet_balance) {
                $wallet_balance         = ($wallet_balance['available_balance'] + $wallet_balance['pending_received_balance']);
            } else {
                $wallet_balance         = "";
            }

            if ($confirmations >= 3 &&
                $wallet_balance >= ($value_in_btc - 0.0001)) //receive value minus network fee
            {
                if ($status <= 2) {
                    DB::beginTransaction();

                    //Update status to completed/processed
                    $status = 2; //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                    BlockioWalletClass::setWalletReceivingDetails($receiving_address, $senders_address, $transaction_hash, $confirmations, $wallet_balance, $status);

                    //Process payment
                    if ($payment_type == "P") {
                        DB::commit();
                    } elseif ($payment_type == "PA") {
                        //Upgrade the sender
                        PAGBClass::setUserClass($sender_user_id, $payment_specific);
                        DB::commit();

                        //Distribute fund

                    } elseif ($payment_type == "PH") {
                        DB::commit();
                    }
                }
            }

            return $confirmations;
        }
    }

    public static function getTransactionDetails($receiving_address, $transaction_hash)
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
                $data = $response->data;
                $data_network = $data->network;

                foreach($data->txs as $data_txs)
                {
                    $data_txs_txid                          = $data_txs->txid;
                    $data_txs_from_green_address            = $data_txs->from_green_address;
                    $data_txs_time                          = $data_txs->time;
                    $data_txs_confirmations                 = $data_txs->confirmations;
                    $data_txs_amounts_received              = $data_txs->amounts_received;
                    //$data_txs_amounts_received_recipient    = $data_txs_amounts_received->recipient;
                    //$data_txs_amounts_received_amount       = $data_txs_amounts_received->amount;
                    $data_txs_senders_address               = "";
                    foreach($data_txs->senders as $data_txs_senders) {
                        $data_txs_senders_address           = $data_txs_senders;
                    }
                    $data_txs_confidence                    = $data_txs->confidence;
                    $data_txs_propagated_by_nodes           = $data_txs->propagated_by_nodes;

                    if($data_txs_txid == $transaction_hash)
                    {
                        $return['txid']                 = $data_txs_txid;
                        $return['from_green_address']   = $data_txs_from_green_address;
                        $return['time']                 = $data_txs_time;
                        $return['confirmations']        = $data_txs_confirmations;
                        $return['amounts_received']     = $data_txs_amounts_received;
                        //$return['recipient']            = $data_txs_amounts_received_recipient;
                        //$return['amount']               = $data_txs_amounts_received_amount;
                        $return['senders']              = $data_txs_senders_address;
                        $return['confidence']           = $data_txs_confidence;
                        $return['propagated_by_nodes']  = $data_txs_propagated_by_nodes;

                        return $return;
                    }
                }
            }

            return false;
        } else {
            return false;
        }
    }

    public static function findTransaction($receiving_address, $value_in_btc)
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
                $data           = $response->data;
                $data_network   = $data->network;

                foreach($data->txs as $data_txs)
                {
                    $data_txs_txid                              = $data_txs->txid;
                    $data_txs_from_green_address                = $data_txs->from_green_address;
                    $data_txs_time                              = $data_txs->time;
                    $data_txs_confirmations                     = $data_txs->confirmations;
                    $data_txs_amounts_received                  = $data_txs->amounts_received;
                    //$data_txs_amounts_received_recipient        = $data_txs_amounts_received->recipient;
                    //$data_txs_amounts_received_amount           = $data_txs_amounts_received->amount;
                    $data_txs_senders                           = $data_txs->senders;
                    $data_txs_confidence                        = $data_txs->confidence;
                    $data_txs_propagated_by_nodes               = $data_txs->propagated_by_nodes;

                    if($data_txs_amounts_received_amount >= $value_in_btc)
                    {
                        $return['txid']                 = $data_txs_txid;
                        $return['from_green_address']   = $data_txs_from_green_address;
                        $return['time']                 = $data_txs_time;
                        $return['confirmations']        = $data_txs_confirmations;
                        $return['amounts_received']     = $data_txs_amounts_received;
                        //$return['recipient'] = $data_txs_amounts_received_recipient;
                        //$return['amount'] = $data_txs_amounts_received_amount;
                        $return['senders']              = $data_txs_senders;
                        $return['confidence']           = $data_txs_confidence;
                        $return['propagated_by_nodes']  = $data_txs_propagated_by_nodes;

                        return $return;
                    }
                }
            }

            return false;
        } else {
            return false;
        }
    }

    public static function setWalletReceivingStatus($receiving_address, $status)
    {
        $bitcoin_blockio_wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address', '=', $receiving_address)
            ->first();

        if (!empty($bitcoin_blockio_wallet_receiving)) {
            $bitcoin_blockio_wallet_receiving->status = $status;
            $bitcoin_blockio_wallet_receiving->save();
        }
    }

    public static function getWalletReceivingStatus($receiving_address)
    {
        $bitcoin_blockio_wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address', '=', $receiving_address)
            ->first();

        if (!empty($bitcoin_blockio_wallet_receiving)) {
            $status = $bitcoin_blockio_wallet_receiving->status;

            return $status;
        } else {
            return false;
        }
    }

    public static function setWalletReceivingDetails($receiving_address, $sender_address, $transaction_hash, $confirmations, $wallet_balance = "", $status = "")
    {
        $bitcoin_blockio_wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address', '=', $receiving_address)
            ->first();

        if (!empty($bitcoin_blockio_wallet_receiving)) {
            $bitcoin_blockio_wallet_receiving->sender_address                               = $sender_address;
            $bitcoin_blockio_wallet_receiving->transaction_hash                             = $transaction_hash;
            $bitcoin_blockio_wallet_receiving->confirmations                                = $confirmations;
            if (!empty($wallet_balance)) $bitcoin_blockio_wallet_receiving->wallet_balance  = $wallet_balance;
            if (!empty($status)) $bitcoin_blockio_wallet_receiving->status                  = $status;
            $bitcoin_blockio_wallet_receiving->save();
        }
    }

    public static function getWalletReceivingDetails($receiving_address)
    {
        $bitcoin_blockio_wallet_receiving = BitcoinBlockioWalletReceiving::where('receiving_address', '=', $receiving_address)
            ->first();

        if (!empty($bitcoin_blockio_wallet_receiving)) {
            $return['id']                   = $bitcoin_blockio_wallet_receiving->id;
            $return['bitcoin_wallet_id']    = $bitcoin_blockio_wallet_receiving->bitcoin_wallet_id;
            $return['user_id']              = $bitcoin_blockio_wallet_receiving->user_id;
            $return['sender_user_id']       = $bitcoin_blockio_wallet_receiving->sender_user_id;
            $return['payment_type']         = $bitcoin_blockio_wallet_receiving->payment_type;
            $return['payment_specific']     = $bitcoin_blockio_wallet_receiving->payment_specific;
            $return['wallet_address']       = $bitcoin_blockio_wallet_receiving->wallet_address;
            $return['sender_address']       = $bitcoin_blockio_wallet_receiving->sender_address;
            $return['value_in_btc']         = $bitcoin_blockio_wallet_receiving->value_in_btc;
            $return['transaction_hash']     = $bitcoin_blockio_wallet_receiving->transaction_hash;
            $return['confirmations']        = $bitcoin_blockio_wallet_receiving->confirmations;
            $return['secret']               = $bitcoin_blockio_wallet_receiving->secret;
            $return['status']               = $bitcoin_blockio_wallet_receiving->status;
            $return['wallet_balance']       = $bitcoin_blockio_wallet_receiving->wallet_balance;
            $return['created_at']           = $bitcoin_blockio_wallet_receiving->created_at;

            return $return;
        } else {
            return false;
        }
    }

    public static function getWalletDetails($user_id)
    {
        $bitcoin_blockio_wallet = BitcoinBlockioWallet::where('user_id', '=', $user_id)
            ->first();

        if (!empty($bitcoin_blockio_wallet)) {
            $return['id']               = $bitcoin_blockio_wallet->id;
            $return['label']            = $bitcoin_blockio_wallet->label;
            $return['wallet_address']   = $bitcoin_blockio_wallet->wallet_address;

            return $return;
        } else {
            return false;
        }
    }

    //============

    public static function getWalletBalance($wallet_address)
    {
        $url = "https://block.io/api/v2/get_address_balance/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY'),
                'addresses' => $wallet_address
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;
            if ($status == "success") {
                $data                           = $response->data;
                $data_network                   = $data->network;
                $data_available_balance         = $data->available_balance;
                $data_pending_received_balance  = $data->pending_received_balance;

                $return['available_balance']        = $data_available_balance;
                $return['pending_received_balance'] = $data_pending_received_balance;

                return $return;
            }

            return false;
        } else {
            return false;
        }
    }

    public static function getReceivingAddressUser($user_id, $sender_user_id, $payment_type, $value_in_btc, $payment_specific = "", $onbehalf_user_id = "")
    {
        $bitcoin_blockchain_wallet = BitcoinBlockioWalletReceiving::where('user_id', '=', $user_id)
            ->where('sender_user_id', '=', $sender_user_id)
            ->where('payment_type', '=', $payment_type)
            ->where('payment_specific', '=', $payment_specific)
            ->where('status', '<', '2')
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"'.Carbon::now().'")'), "<", ($payment_type == "PA" ? 65 : 15))
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($bitcoin_blockchain_wallet)) {
            $user = User::find($user_id);
            $user_wallet_address = $user->wallet_address;
            $bitcoin_wallet_id      = 0;
            $bitcoin_wallet_label   = "Personal_Wallet";
            $wallet_address         = $user_wallet_address;

            $return = self::createReceivingAddress($user_id, $sender_user_id, $bitcoin_wallet_id, $bitcoin_wallet_label, $wallet_address, $payment_type, $value_in_btc, $payment_specific, $onbehalf_user_id);
            return $return;
        }

        $return['id']                   = $bitcoin_blockchain_wallet->id;
        $return['receiving_address']    = $bitcoin_blockchain_wallet->receiving_address;

        return $return;
    }

    public static function getReceivingAddress($user_id, $sender_user_id, $payment_type, $value_in_btc, $payment_specific = "", $onbehalf_user_id = "")
    {
        $bitcoin_blockchain_wallet = BitcoinBlockioWalletReceiving::where('user_id', '=', $user_id)
            ->where('sender_user_id', '=', $sender_user_id)
            ->where('payment_type', '=', $payment_type)
            ->where('payment_specific', '=', $payment_specific)
            ->where('status', '<', '2')
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, `created_at`,"'.Carbon::now().'")'), "<", ($payment_type == "PA" ? 65 : 15))
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($bitcoin_blockchain_wallet)) {
            $bitcoin_blockio_wallet = self::getWalletAddress($user_id);
            $bitcoin_wallet_id      = $bitcoin_blockio_wallet['id'];
            $bitcoin_wallet_label   = $bitcoin_blockio_wallet['label'];
            $wallet_address         = $bitcoin_blockio_wallet['wallet_address'];

            $return = self::createReceivingAddress($user_id, $sender_user_id, $bitcoin_wallet_id, $bitcoin_wallet_label, $wallet_address, $payment_type, $value_in_btc, $payment_specific, $onbehalf_user_id);
            return $return;
        }

        $return['id']                   = $bitcoin_blockchain_wallet->id;
        $return['receiving_address']    = $bitcoin_blockchain_wallet->receiving_address;

        return $return;
    }

    public static function createReceivingAddress($user_id, $sender_user_id, $bitcoin_wallet_id, $bitcoin_wallet_label, $wallet_address, $payment_type, $value_in_btc, $payment_specific = "", $onbehalf_user_id = "")
    {
        $secret = BitcoinWalletClass::generateSecret();
        $url = "https://pf.block.io/api/v2/create_forwarding_address/";
        $callback_url_specific = self::$callback_url.$secret;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'       => false,
            'verify'            => false,
            'query' => [
                'api_key'       => env('BLOCKIO_APP_KEY'),
                'to_address'    => $wallet_address
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status                         = $response->status;
            $data                           = $response->data;
            $data_network                   = $data->network;
            $data_forwarding_private_key    = $data->forwarding_private_key;
            $receiving_address              = $data->forwarding_address;

            self::addApiHistory($status, $data, $user_id, $sender_user_id);

            if ($status == "success") {
                //set callback
                $bitcoin_blockio_callback       = self::setCallback($receiving_address, $callback_url_specific);

                //if fail to create call back just use manual callback
                if ($bitcoin_blockio_callback)
                {
                    $bitcoin_blockio_callback_id    = $bitcoin_blockio_callback['data']['notification_id'];
                } else {
                    $bitcoin_blockio_callback = true;
                    $bitcoin_blockio_callback_id = "";
                }

                if ($bitcoin_blockio_callback) {
                    $bitcoin_blockio_wallet = new BitcoinBlockioWalletReceiving();
                    $bitcoin_blockio_wallet->bitcoin_wallet_id                                  = $bitcoin_wallet_id;
                    $bitcoin_blockio_wallet->user_id                                            = $user_id;
                    $bitcoin_blockio_wallet->sender_user_id                                     = $sender_user_id;
                    if (!empty($onbehalf_user_id)) $bitcoin_blockio_wallet->onbehalf_user_id    = $onbehalf_user_id;
                    $bitcoin_blockio_wallet->payment_type                                       = $payment_type;
                    $bitcoin_blockio_wallet->payment_specific                                   = $payment_specific;
                    $bitcoin_blockio_wallet->value_in_btc                                       = $value_in_btc;
                    $bitcoin_blockio_wallet->wallet_label                                       = $bitcoin_wallet_label;
                    $bitcoin_blockio_wallet->wallet_address                                     = $wallet_address;
                    $bitcoin_blockio_wallet->receiving_address                                  = $receiving_address;
                    $bitcoin_blockio_wallet->network                                            = $data_network;
                    $bitcoin_blockio_wallet->forwarding_private_key                             = $data_forwarding_private_key;
                    $bitcoin_blockio_wallet->secret                                             = $secret;
                    $bitcoin_blockio_wallet->callback_url                                       = $callback_url_specific;
                    $bitcoin_blockio_wallet->callback_id                                        = $bitcoin_blockio_callback_id;
                    $bitcoin_blockio_wallet->save();

                    $return['id']                   = $bitcoin_blockio_wallet->id;
                    $return['receiving_address']    = $bitcoin_blockio_wallet->receiving_address;

                    return $return;
                }
            }

            return false;
        } else {
            return false;
        }
    }

    public static function getWalletAddress($user_id)
    {
        $bitcoin_blockchain_wallet = BitcoinBlockioWallet::where('user_id', '=', $user_id)
            ->first();

        if (empty($bitcoin_blockchain_wallet)) {
            $label  = "BR_Wallet_".$user_id;
            $return = self::createWalletAddress($label, $user_id);

            return $return;
        }

        $return['id']               = $bitcoin_blockchain_wallet->id;
        $return['label']            = $bitcoin_blockchain_wallet->label;
        $return['wallet_address']   = $bitcoin_blockchain_wallet->wallet_address;

        return $return;
    }

    public static function getWalletAddressRemote($label)
    {
        $url = "https://block.io/api/v2/get_my_addresses/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;

            if ($status == "success")
            {
                $data = $response->data;
                $network = $data->network;
                //$address = $data->addresses;

                foreach($data->addresses as $addresses)
                {
                    if($addresses->label == $label)
                    {
                        $return['network']                      = $network;
                        $return['user_id']                      = $addresses->user_id;
                        $return['address']                      = $addresses->address;
                        $return['label']                        = $addresses->label;
                        $return['available_balance']            = $addresses->available_balance;
                        $return['pending_received_balance']     = $addresses->pending_received_balance;

                        return $return;
                    }
                }
            }
        }

        return false;
    }

    public static function createWalletAddress($label, $user_id)
    {
        $url = "https://block.io/api/v2/get_new_address/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY'),
                'label'     => $label
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());

            $status         = $response->status;
            $data           = $response->data;
            $data_network   = $data->network;
            $data_user_id   = $data->user_id;
            $data_address   = $data->address;
            $data_label     = $data->label;

            self::addApiHistory($status, $data, $user_id);

            if ($status == "success") {
                $bitcoin_blockio_wallet = new BitcoinBlockioWallet();
                $bitcoin_blockio_wallet->user_id        = $user_id;
                $bitcoin_blockio_wallet->network        = $data_network;
                $bitcoin_blockio_wallet->data_user_id   = $data_user_id;
                $bitcoin_blockio_wallet->label          = $data_label;
                $bitcoin_blockio_wallet->wallet_address = $data_address;
                $bitcoin_blockio_wallet->save();

                $return['id']               = $bitcoin_blockio_wallet->id;
                $return['label']            = $bitcoin_blockio_wallet->label;
                $return['wallet_address']   = $bitcoin_blockio_wallet->wallet_address;

                return $return;
            }
        } else {
            $response = json_decode($response->getBody()->getContents());

            $status = $response->status;
            if ($status == "fail") {
                $data               = $response->data;
                $data_error_message = $data->error_message;

                if (!empty(strpos($data_error_message,"already exists"))) {
                    $response = self::getWalletAddressRemote($label);

                    if ($response) {
                        $bitcoin_blockio_wallet = new BitcoinBlockioWallet();
                        $bitcoin_blockio_wallet->user_id        = $user_id;
                        $bitcoin_blockio_wallet->network        = $response['network'];
                        $bitcoin_blockio_wallet->data_user_id   = $response['user_id'];
                        $bitcoin_blockio_wallet->label          = $response['label'];
                        $bitcoin_blockio_wallet->wallet_address = $response['address'];
                        $bitcoin_blockio_wallet->save();

                        $return['id']               = $bitcoin_blockio_wallet->id;
                        $return['label']            = $bitcoin_blockio_wallet->label;
                        $return['wallet_address']   = $bitcoin_blockio_wallet->wallet_address;

                        return $return;
                    }
                }
            }
        }

        return false;
    }

    public static function setCallback($address, $callback_url)
    {
        $url = "https://block.io/api/v2/create_notification/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY'),
                'type'      => "address",
                'address'   => $address,
                'url'       => $callback_url
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response           = json_decode($response->getBody()->getContents());
            $status             = $response->status;
            $data               = $response->data;

            self::addApiHistory($status, $data);

            if ($status == "success") {
                $return['status']                   = $status;
                $return['data']['network']          = $data->network;
                $return['data']['notification_id']  = $data->notification_id;
                $return['data']['type']             = $data->type;
                $return['data']['enabled']          = $data->enabled;
                $return['data']['url']              = $data->url;

                return $return;
            }
        } else {
            $response           = json_decode($response->getBody()->getContents());
            $status             = $response->status;
            $data               = $response->data;

            self::addApiHistory($status, $data);

            /*
            if ($status == "fail") {
                return self::setCallback($address, $callback_url);
            }
            */
        }

        return false;
    }

    public static function delAllCallback()
    {
        $url = "https://block.io/api/v2/get_notifications/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'   => false,
            'verify'        => false,
            'query' => [
                'api_key'   => env('BLOCKIO_APP_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());
            $return['status'] = $response->status;

            if ($return['status'] == "success") {
                foreach ($response->data as $data)
                {
                    echo $data->notification_id."<br>";
                    self::delCallback($data->notification_id);
                    echo $data->notification_id." deleted<br>";
                }
            }
        }
    }

    public static function delCallback($notification_id)
    {
        $url = "https://block.io/api/v2/delete_notification/";

        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'http_errors'         => false,
            'verify'              => false,
            'query' => [
                'api_key'         => env('BLOCKIO_APP_KEY'),
                'notification_id' => $notification_id
            ]
        ]);
    }
}