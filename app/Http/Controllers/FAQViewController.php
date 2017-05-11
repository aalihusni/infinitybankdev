<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faq;

class FAQViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $faq = Faq::orderBy('order','ASC')->get();

        if(count($faq))
        {
            $last = Faq::orderBy('order','DESC')->first();
        }
        else
        {
            $last = 'none';
        }

        return view('admin.manage_faq')->with('faqs',$faq)->with('last',$last);
    }

    public function edit()
    {
        $id = $_GET['id'];
        $faq = Faq::find($id);
        return view('admin.edit_faq')->with('faq',$faq);
    }

    public function view()
    {
        $faq = Faq::orderBy('order','ASC')->get();
        return view('member.faq')->with('faqs',$faq);
    }
}
