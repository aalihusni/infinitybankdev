<?php
namespace App\Classes;

use App\BitcoinBlockioWalletReceiving;

class PaymentClass
{
    public static function getPendingTransaction($sender_user_id)
    {
        $pending_transactions = BitcoinBlockioWalletReceiving::where('sender_user_id', '=', $sender_user_id)
            ->where('status', '>=', '1')
            ->where('status', '<=', '2')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!empty($pending_transactions)) {
            $return['receiving_address'] = $pending_transactions->receiving_address;
            $return['sender_address'] = $pending_transactions->sender_address;
            $return['transaction_hash'] = $pending_transactions->transaction_hash;
            $return['value_in_btc'] = $pending_transactions->value_in_btc;
            $return['confirmations'] = $pending_transactions->confirmations;

            return $return;
        }

        return false;
    }
}