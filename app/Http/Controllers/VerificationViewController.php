<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use User;

class VerificationViewController extends Controller
{
    public function index()
    {
        return view('member.verification');
    }
}
