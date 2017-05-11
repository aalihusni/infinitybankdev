<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Faq;
use Redirect;

class FAQController extends Controller
{
    public function add()
    {
        $question = $_POST['question'];
        $order = $_POST['order'];
        $lang = $_POST['lang'];
        $answer = $_POST['answer'];

        $faq = new Faq();
        $faq->lang = $lang;
        $faq->order = $order;
        $faq->question = $question;
        $faq->answer = $answer;
        $faq->save();

        return Redirect::to('admin/manage-faq')->with('success', 'New FAQ has been added!');
    }

    public function edit()
    {
        $id = $_POST['id'];
        $question = $_POST['question'];
        $order = $_POST['order'];
        $lang = $_POST['lang'];
        $answer = $_POST['answer'];

        $faq = Faq::find($id);
        $faq->lang = $lang;
        $faq->order = $order;
        $faq->question = $question;
        $faq->answer = $answer;
        $faq->save();

        return Redirect::to('admin/manage-faq')->with('success', 'New FAQ has been updated!');
    }

    public function delete()
    {
        $id = $_POST['id'];

        $faq = Faq::find($id);
        $faq->delete();

        return Redirect::to('admin/manage-faq')->with('success', 'New FAQ has been added!');
    }

}
