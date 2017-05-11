<?php
namespace App\Classes;

use App\BitcoinBlockioCallbackProcessLog;
use DB;

class BlockioCallbackProcessLogClass
{
    public static $saveLog = true;

    public static function addLog($callback_id = "", $user_id = "", $sender_user_id = "", $process = "", $data = "")
    {
        if (self::$saveLog == true)
        {
            $callback_process_log = new BitcoinBlockioCallbackProcessLog();
            $callback_process_log->callback_id = $callback_id;
            $callback_process_log->user_id = $user_id;
            $callback_process_log->sender_user_id = $sender_user_id;
            $callback_process_log->process = $process;
            $callback_process_log->data = $data;
            $callback_process_log->save();
        }
    }
}