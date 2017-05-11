<?php
namespace App\Classes;

use App\Email;
use App\EmailLabel;
use App\User;
use Mail;

class EmailClass
{
    public static function add_email($template, $email, $subject, $data, $user_id = "", $label = "")
    {
        if(empty($user_id))
        {
            $user_id = User::where('email','=',$email)->first()->id;
        }

        $email = new Email();
        $email->user_id = $user_id;
        $email->subject = $subject;
        $email->template = $template;
        $email->data = json_encode($data);
        if (!empty($label)) {
            $email->label = $label;
        }
        $email->save();

    }

    public static function send_email($template, $email, $subject, $data, $send, $user_id = "", $label = "")
    {
        self::add_email($template, $email, $subject, $data, $user_id, $label);

        if($send == 1)
        {
            Mail::send($template, $data, function($message) use($email, $subject)
            {
                $message->to($email)->subject($subject);
            });
        }
    }

    public static function set_email_status($id, $status)
    {
        $email = Email::find($id);
        $email->status = $status;
        $email->save();

        return $email;
    }

    public static function get_email_count($user_id, $status = "", $condition = "=")
    {
        $sql = Email::where('user_id', '=', $user_id);
        if ($status == "") {
            $sql->where('status', $condition, $status);
        }
        $email = $sql->count();

        return $email;
    }

    public static function get_email($id)
    {
        $email = Email::find($id);
        return $email;
    }

    public static function get_all_email($user_id, $label = "", $status = "", $condition = "=", $limit = "")
    {
        $sql = Email::where('user_id', '=', $user_id);
        if (!empty($label)) {
            $sql->where('label', '=', $label);
        }
        if ($status != "") {
            $sql->where('status', $condition, $status);
        }
        $sql->orderby('created_at', 'desc');
        if (!empty($limit)) {
            $sql->take($limit);
        }
        $email = $sql->get();

        return $email;
    }

    public static function get_all_pool_email($label = "", $status = "", $condition = "=", $limit = "")
    {
        $sql = Email::where('user_id', '<=', '3281');
        if (!empty($label)) {
            $sql->where('label', '=', $label);
        }
        if ($status != "") {
            $sql->where('status', $condition, $status);
        }
        $sql->orderby('created_at', 'desc');
        if (!empty($limit)) {
            $sql->take($limit);
        }
        $email = $sql->get();

        return $email;
    }

    public static function get_email_label()
    {
        $email_label = EmailLabel::get();
        return $email_label;
    }
}