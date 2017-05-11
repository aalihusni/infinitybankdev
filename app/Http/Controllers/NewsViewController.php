<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;

class NewsViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('member');
    }

    public function index()
    {
        $news = News::orderBy('created_at','DESC')->get();
        return view('member.news')->with('news',$news);
    }

    public function manage_news()
    {
        $news = News::orderBy('created_at','DESC')->get();
        return view('admin.manage_news')->with('news',$news);
    }

    public function edit_news()
    {
        $id = $_GET['id'];
        $news = News::find($id);
        return view('admin.edit_news')->with('news',$news);
    }

    public function blast_news()
    {
        $id = $_GET['id'];
        $news = News::find($id);
        return view('admin.blast_news')->with('news',$news);
    }
}
