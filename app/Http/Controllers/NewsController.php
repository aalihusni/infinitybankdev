<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;
use App\User;
use Redirect;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function add_news()
    {
        $title = $_POST['title'];
        $lang = $_POST['lang'];
        $news = $_POST['news'];

        $faq = new News();
        $faq->lang = $lang;
        $faq->title = $title;
        $faq->news = $news;
        $faq->save();

        return Redirect::to('admin/manage-news')->with('success', 'News has been added!');
    }

    public function edit_news()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $lang = $_POST['lang'];
        $news = $_POST['news'];

        $faq = News::find($id);
        $faq->lang = $lang;
        $faq->title = $title;
        $faq->news = $news;
        $faq->save();

        return Redirect::to('admin/manage-news')->with('success', 'News has been updated!');
    }

    public function publish_news()
    {
        $id = $_GET['id'];

        $faq = News::find($id);
        $faq->order = '1';
        $faq->save();

        return Redirect::to('admin/manage-news')->with('success', 'News has been updated!');
    }

    public function unpublish_news()
    {
        $id = $_GET['id'];

        $faq = News::find($id);
        $faq->order = '';
        $faq->save();

        return Redirect::to('admin/manage-news')->with('success', 'News has been updated!');
    }

    public function delete_news()
    {
        $id = $_POST['id'];
        $news = News::find($id);
        $news->delete();

        return Redirect::to('admin/manage-news')->with('success', 'New FAQ has been added!');
    }

    public function generate_members_csv()
    {
        $rows = User::where('user_type','=',2)->where('id','>',3281)->select('firstname','lastname','email')->get();
        $list = array();
        foreach ($rows as $row)
        {
            $list [] = [$row->firstname,$row->lastname,$row->email];
        }
        $filename = base_path()."/public/admin/export/all_members.csv";
        $fp = fopen($filename, 'w');
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        return 'Generate All Members Complete! <a href="export/all_members.csv" download>[DOWNLOAD NOW]</a>';
    }

    public function generate_nonmembers_csv()
    {
        $rows = User::where('user_type','=',3)->where('id','>',3281)->select('firstname','lastname','email')->get();
        $list = array();
        foreach ($rows as $row)
        {
            $list [] = [$row->firstname,$row->lastname,$row->email];
        }
        $filename = base_path()."/public/admin/export/all_nonmembers.csv";
        $fp = fopen($filename, 'w');
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        return 'Generate All Non-Members Complete! <a href="export/all_nonmembers.csv" download>[DOWNLOAD NOW]</a>';
    }
}
