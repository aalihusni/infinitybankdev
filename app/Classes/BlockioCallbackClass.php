<?php
namespace App\Classes;

use App\BitcoinBlockioCallback;
use App\Classes\BlockioWalletClass;
use App\Classes\PAGBClass;
use App\Classes\PassportClass;
use App\Classes\MicroPassportClass;
use App\Classes\BlockioCallbackProcessLogClass;
use App\Classes\IPClass;
use App\Classes\PHGHClass;
use App\Classes\MicroPHGHClass;
use DB;
use Request;
use Input;
use Carbon\Carbon;

class BlockioCallbackClass
{
    public static function getCallback($notification_raw_data)
    {
        BlockioCallbackProcessLogClass::addLog("", "", "", "Received callback", json_encode($notification_raw_data));
        $input = json_decode($notification_raw_data);
        if (isset($input->notification_id)) $notification_id                = $input->notification_id;
        if (isset($input->delivery_attempt)) $notification_delivery_attempt = $input->delivery_attempt;
        $notification_type                                                  = "";
        if (isset($input->type)) $notification_type                         = $input->type;
        if (isset($input->data)) {
            $data                                                           = $input->data;
            $notification_data                                              = json_encode($data);
        }
        if (isset($input->created_at)) $notification_created_at             = $input->created_at;
        $secret                                                             = $input->secret;
        $referer_url                                                        = Request::server('HTTP_REFERER');
        $client_ip                                                          = IPClass::getip();

        if ($notification_type == "address" && isset($data))
        {
            $data_network           = $data->network;
            $data_address           = $data->address;
            $data_balance_change    = $data->balance_change;
            $data_amount_sent       = $data->amount_sent;
            $data_amount_received   = $data->amount_received;
            $data_txid              = $data->txid;
            $data_confirmations     = $data->confirmations;
            $data_is_green          = $data->is_green;
            $notification_raw_data  = json_encode($input);

            $sender_address = BlockioWalletClass::getTransactionDetails($data_address, $data_txid);
            if ($sender_address) {
                $sender_address = $sender_address['senders'];
            } else {
                $sender_address = "";
            }

            $response = self::setCallback($sender_address, $data_txid, $data_address, $data_amount_sent, $data_amount_received, $data_confirmations, $secret, $referer_url, $client_ip, $notification_id, $notification_delivery_attempt, $notification_type, $notification_data, $notification_created_at, $notification_raw_data);
        }
        elseif ($notification_type == "new-blocks" && isset($data))
        {
            $data_network               = $data->network;
            $data_block_hash            = $data->block_hash;
            $data_previous_block_hash   = $data->previous_block_hash;
            $data_block_no              = $data->block_no;
            $data_confirmations         = $data->confirmations;
            $data_merkle_root           = $data->merkle_root;
            $data_time                  = $data->time;
            $data_nonce                 = $data->nonce;
            $data_difficulty            = $data->difficulty;
            $data_txs                   = $data->txs;
        }
        elseif ($notification_type == "new-transactions" && isset($data))
        {
            $data_network           = $data->network;
            $data_txid              = $data->txid;
            $data_confirmations     = $data->confirmations;
            $data_block_hash        = $data->block_hash;
            $data_block_no          = $data->block_no;
            $data_block_time        = $data->block_time;
            $data_received_at       = $data->received_at;
            $data_network_fee       = $data->network_fee;
            $data_amount_received   = $data->amount_received;
            $data_is_green          = $data->is_green;
            $data_inputs            = $data->inputs;
            $data_outputs           = $data->outputs;
        }
    }

    public static function setCallback($sender_address, $data_txid, $data_address, $data_amount_sent, $data_amount_received, $data_confirmations, $secret, $referer_url, $client_ip, $notification_id, $notification_delivery_attempt, $notification_type, $notification_data, $notification_created_at, $notification_raw_data)
    {
        $transaction_hash   = $data_txid;
        $input_address      = $data_address;
        $value_in_btc       = $data_amount_received;
        $confirmations      = $data_confirmations;

        //Get transaction details
        $transaction_details = self::getTransactionDetails($data_address);
        if ($transaction_details) {
            //Get wallet receiving details
            $wallet_receiving_id                = $transaction_details['id'];
            $wallet_receiving_user_id           = $transaction_details['user_id'];
            $wallet_receiving_sender_user_id    = $transaction_details['sender_user_id'];
            $wallet_receiving_payment_type      = $transaction_details['payment_type'];
            $wallet_receiving_payment_specific  = $transaction_details['payment_specific'];
            $wallet_receiving_value_in_btc      = $transaction_details['value_in_btc'];
            $wallet_receiving_secret            = $transaction_details['secret'];
            $wallet_receiving_status            = $transaction_details['status'];

            //Get wallet details
            $wallet_id                          = $transaction_details['bitcoin_wallet_id'];
            $wallet_address                     = $transaction_details['wallet_address'];

            //Save callback
            $bitcoin_blockio_callback = new BitcoinBlockioCallback();

            //Save callback inputs
            $bitcoin_blockio_callback->transaction_hash                 = $transaction_hash;
            $bitcoin_blockio_callback->receiving_address                = $input_address;
            $bitcoin_blockio_callback->sender_address                   = $sender_address;
            $bitcoin_blockio_callback->value_in_btc                     = $value_in_btc;
            $bitcoin_blockio_callback->confirmations                    = $confirmations;
            $bitcoin_blockio_callback->secret                           = $secret;
            $bitcoin_blockio_callback->referer_url                      = $referer_url;
            $bitcoin_blockio_callback->client_ip                        = $client_ip;

            //Save blockio notification inputs
            $bitcoin_blockio_callback->notification_id                  = $notification_id;
            $bitcoin_blockio_callback->notification_delivery_attempt    = $notification_delivery_attempt;
            $bitcoin_blockio_callback->notification_type                = $notification_type;
            $bitcoin_blockio_callback->notification_data                = $notification_data;
            $bitcoin_blockio_callback->notification_created_at          = $notification_created_at;
            $bitcoin_blockio_callback->notification_raw_data            = $notification_raw_data;

            //Save receiving details
            $bitcoin_blockio_callback->bitcoin_wallet_receiving_id      = $wallet_receiving_id;
            $bitcoin_blockio_callback->bitcoin_wallet_id                = $wallet_id;
            $bitcoin_blockio_callback->user_id                          = $wallet_receiving_user_id;
            $bitcoin_blockio_callback->sender_user_id                   = $wallet_receiving_sender_user_id;
            $bitcoin_blockio_callback->payment_type                     = $wallet_receiving_payment_type;
            $bitcoin_blockio_callback->payment_specific                 = $wallet_receiving_payment_specific;

            //Get wallet and confirmed wallet balance
            $wallet_balance = 0;
            $get_wallet_balance = BlockioWalletClass::getWalletBalance($wallet_address);
            if ($get_wallet_balance) $wallet_balance = ($get_wallet_balance['available_balance'] + $get_wallet_balance['pending_received_balance']);

            //Save wallet and confirmed wallet balance
            if($wallet_balance) $bitcoin_blockio_callback->wallet_balance = $wallet_balance;

            //Count callback for particular receiving address
            $callback_counts = self::getCallbackCounts($input_address);
            //Save callback counts
            $bitcoin_blockio_callback->callback_counts = $callback_counts + 1;

            //Saved
            $bitcoin_blockio_callback->save();

            //Proceed if secret is valid and value more than requested
            if ($secret == $wallet_receiving_secret &&
                $value_in_btc >= $wallet_receiving_value_in_btc)
            {
                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "secret and value ok", "");
                //Process payment if confirmations is more or equal than required and balance more than requested
                if (($confirmations >= 4) || ($confirmations >= 0 && $wallet_receiving_payment_type == "P") || ($confirmations >= 0 && $wallet_receiving_payment_type == "MP") || ($confirmations >= 1 && $wallet_receiving_payment_type == "PH") || ($confirmations >= 1 && $wallet_receiving_payment_type == "MPH") || ($confirmations >= 1 && $wallet_receiving_payment_type == "PA" && $wallet_receiving_payment_specific == 2))
                //if ($confirmations >= 0)
                //if ($confirmations >= 3 &&
                //    $wallet_balance >= ($wallet_receiving_value_in_btc - 0.0001)) //receive value minus network fee
                {
                    //Get Latest Status
                    $wallet_receiving_status = self::getTransactionDetails($input_address)['status'];
                    BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "get latest wallet receiving status", "");

                    if ($wallet_receiving_status <= 1) { //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                        BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "wallet receiving = 1", "");
                        DB::beginTransaction();

                        //Update status to completed/processed
                        $status = 2; //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                        BlockioWalletClass::setWalletReceivingDetails($input_address, $sender_address, $transaction_hash, $confirmations, $wallet_balance, $status);
                        BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "update wallet receiving to 2", "");

                        //Process payment
                        if ($wallet_receiving_payment_type == "P") {
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "update passport balance", "");
                            PassportClass::setPassportBalance($wallet_receiving_sender_user_id, $wallet_receiving_payment_specific, "", $secret);
                            DB::commit();
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "update passport balance success", "");

                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback", "");
                            //Delete Callback
                            BlockioWalletClass::delCallback($notification_id);
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback success", "");
                        } elseif ($wallet_receiving_payment_type == "MP") {
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "update passport balance", "");
                            MicroPassportClass::setPassportBalance($wallet_receiving_sender_user_id, $wallet_receiving_payment_specific, "", $secret);
                            DB::commit();
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "update passport balance success", "");

                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback", "");
                            //Delete Callback
                            BlockioWalletClass::delCallback($notification_id);
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback success", "");

                        } elseif ($wallet_receiving_payment_type == "PA") {
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "upgrade PA", "");
                            //Upgrade the sender
                            PAGBClass::setUserClass($wallet_receiving_sender_user_id, $wallet_receiving_payment_specific);
                            DB::commit();
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "upgrade PA success", "");

                            //Distribute fund
                            if ($wallet_receiving_payment_specific == 1)
                            {
                                $to_addresses = PAGBClass::getUplineReferralWalletAddress($wallet_receiving_sender_user_id);
                                $upline_user_id = $to_addresses['upline_user_id'];
                                $referral_user_id = $to_addresses['referral_user_id'];
                                if ($upline_user_id <> $referral_user_id)
                                {
                                    //PA SPLIT
                                    PAGBClass::splitPA($wallet_receiving_id, $wallet_receiving_sender_user_id, $wallet_address, $to_addresses, $wallet_receiving_value_in_btc, $wallet_receiving_payment_specific, $secret);
                                } else {
                                    //PA
                                    PAGBClass::addPAGB($wallet_receiving_user_id, $wallet_receiving_sender_user_id, $sender_address, $wallet_address, $value_in_btc, $wallet_receiving_payment_specific, $transaction_hash);
                                }
                            }
                            elseif ($wallet_receiving_payment_specific >= 3)
                            {
                                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "distribute PAGB", "");
                                //PAGB
                                $to_addresses = PAGBClass::getPAGBWalletAddress($wallet_receiving_sender_user_id, $wallet_receiving_user_id, $wallet_receiving_payment_specific);
                                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "get wallet address", json_encode($to_addresses));
                                PAGBClass::withdrawPAGB($wallet_receiving_id, $wallet_receiving_sender_user_id, $wallet_address, $to_addresses, $wallet_receiving_value_in_btc, $wallet_receiving_payment_specific, $secret);
                                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "distribute PAGB success", "");
                            } else {
                                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "distribute PA", "");
                                //PA
                                PAGBClass::addPAGB($wallet_receiving_user_id, $wallet_receiving_sender_user_id, $sender_address, $wallet_address, $value_in_btc, $wallet_receiving_payment_specific, $transaction_hash);
                                BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "distribute PAGB success", "");
                            }

                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback", "");
                            //Delete Callback
                            BlockioWalletClass::delCallback($notification_id);
                            BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "delete callback success", "");

                        } elseif ($wallet_receiving_payment_type == "PH") {
                            PHGHClass::setPHGH($wallet_receiving_payment_specific,2);
                            DB::commit();

                            //Delete Callback
                            BlockioWalletClass::delCallback($notification_id);
                        } elseif ($wallet_receiving_payment_type == "MPH") {
                            MicroPHGHClass::setPHGH($wallet_receiving_payment_specific,2);
                            DB::commit();

                            //Delete Callback
                            BlockioWalletClass::delCallback($notification_id);
                        }
                    } else {
                        $status = "";
                        //Update wallet receiving details
                        if ($wallet_receiving_status <= 1) { //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                            $status = 1; //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                        }

                        BlockioWalletClass::setWalletReceivingDetails($input_address, $sender_address, $transaction_hash, $confirmations, $wallet_balance, $status);
                    }
                } else { //Waiting confirmations
                    $status = "";
                    //Update wallet receiving details
                    if ($wallet_receiving_status <= 1) { //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                        $status = 1; //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                    }

                    BlockioWalletClass::setWalletReceivingDetails($input_address, $sender_address, $transaction_hash, $confirmations, $wallet_balance, $status);
                    BlockioCallbackProcessLogClass::addLog($bitcoin_blockio_callback->id, $wallet_receiving_user_id, $wallet_receiving_sender_user_id, "waiting confirmations", "");
                }
            }
            /*else {
                if ($secret == $wallet_receiving_secret &&
                    $value_in_btc > 0)
                {
                    if ($confirmations >= 3)
                    {
                        //Update status to ignored
                        $status = 3; //0 = waiting | 1 = pending | 2 = completed/processed | 3 = ignored
                        BlockioWalletClass::setWalletReceivingDetails($input_address, $sender_address, $transaction_hash, $confirmations, $wallet_balance, $status);
                    }
                }
            }*/
        } else {
            $bitcoin_blockio_callback = new BitcoinBlockioCallback();
            $bitcoin_blockio_callback->transaction_hash                 = $transaction_hash;
            $bitcoin_blockio_callback->receiving_address                = $input_address;
            $bitcoin_blockio_callback->value_in_btc                     = $value_in_btc;
            $bitcoin_blockio_callback->confirmations                    = $confirmations;
            $bitcoin_blockio_callback->secret                           = $secret;
            $bitcoin_blockio_callback->referer_url                      = $referer_url;
            $bitcoin_blockio_callback->client_ip                        = $client_ip;

            $bitcoin_blockio_callback->notification_id                  = $notification_id;
            $bitcoin_blockio_callback->notification_delivery_attempt    = $notification_delivery_attempt;
            $bitcoin_blockio_callback->notification_type                = $notification_type;
            $bitcoin_blockio_callback->notification_data                = $notification_data;
            $bitcoin_blockio_callback->notification_created_at          = $notification_created_at;
            $bitcoin_blockio_callback->notification_raw_data            = $notification_raw_data;

            $bitcoin_blockio_callback->save();
        }

        echo Carbon::now()." : "."Callback Processed"."<br>\r\n";
    }

    public static function getTransactionDetails($receiving_address)
    {
        $wallet_receiving_details = BlockioWalletClass::getWalletReceivingDetails($receiving_address);
        if ($wallet_receiving_details) {
            $return['id']                   = $wallet_receiving_details['id'];
            $return['bitcoin_wallet_id']    = $wallet_receiving_details['bitcoin_wallet_id'];
            $return['user_id']              = $wallet_receiving_details['user_id'];
            $return['sender_user_id']       = $wallet_receiving_details['sender_user_id'];
            $return['payment_type']         = $wallet_receiving_details['payment_type'];
            $return['payment_specific']     = $wallet_receiving_details['payment_specific'];
            $return['wallet_address']       = $wallet_receiving_details['wallet_address'];
            $return['sender_address']       = $wallet_receiving_details['sender_address'];
            $return['value_in_btc']         = $wallet_receiving_details['value_in_btc'];
            $return['secret']               = $wallet_receiving_details['secret'];
            $return['status']               = $wallet_receiving_details['status'];

            return $return;
        }

        return false;
    }

    public static function getCallbackCounts($receiving_address)
    {
        $bitcoin_blockio_callback = BitcoinBlockioCallback::where('receiving_address', '=', $receiving_address)
            ->count();

        return $bitcoin_blockio_callback;
    }
}