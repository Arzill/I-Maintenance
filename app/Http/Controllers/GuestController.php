<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    public function aboutUs()
    {
        return view('pages.aboutUs');
    }
}
