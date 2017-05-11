<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faq;
use App\Classes\EmailClass;
use Auth;
use Input;
use Crypt;

class EmailViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function inbox()
    {
        $id = Input::get("view");
        $label = Input::get("label");
        $status = Input::get("status");
        $user_id = Auth::user()->id;
        if (!empty($label)) {
            $label = Crypt::decrypt($label);
        }
        if (!empty($status)) {
            $status = Crypt::decrypt($status);
        }
        $emails = EmailClass::get_all_email($user_id, $label, "$status");
        $email_labels = EmailClass::get_email_label();

        if (empty($id)) {
            $email_count = EmailClass::get_email_count($user_id, 0);
            return view('member.email_')->with('emails', $emails)->with('email_labels', $email_labels)->with('email_count', $email_count);
        } else {
            $id = Crypt::decrypt($id);
            EmailClass::set_email_status($id, 1);
            $email_count = EmailClass::get_email_count($user_id, 0);
            $email_class = EmailClass::get_email($id);
            $data = json_decode($email_class->data, true);

            return view('member.email_')->with('emails', $emails)->with('email_labels', $email_labels)->with('email_count', $email_count)->with('email_class', $email_class)->with($data);
        }

    }

    public function view_email($id = "")
    {
        if (empty($id)) {
            $id = Input::get('id');
        }
        EmailClass::set_email_status($id, 1);
        $email_class = EmailClass::get_email($id);
        $template = $email_class->template;
        $subject = $email_class->subject;
        $data = json_decode($email_class->data, true);

        return view($template)->with('subject', $subject)->with($data);
    }

    public function admin_email()
    {
        $user_id = Auth::user()->id;
        $emails = EmailClass::get_all_pool_email();

        return view('admin.emails')->with('emails', $emails);
    }

    public function admin_view_email($id = "")
    {
        if (empty($id)) {
            $id = Input::get('id');
        }
        EmailClass::set_email_status($id, 1);
        $email_class = EmailClass::get_email($id);
        $template = $email_class->template;
        $subject = $email_class->subject;
        $data = json_decode($email_class->data, true);

        return view("admin.view-email")->with('template', $template)->with('subject', $subject)->with($data);
    }
}