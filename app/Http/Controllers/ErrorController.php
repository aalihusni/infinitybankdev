<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public function defaultError()
    {
        return view('errors.500');
    }
}