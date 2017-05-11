<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Redirect;


class LanguangeController extends Controller
{

    public function set_locale()
    {
        $lang = $_GET['lang'];
        Session::put('lang', $lang);

        return Redirect::back();
    }

}