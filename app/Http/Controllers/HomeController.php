<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function getHome()
    {
        return view('user.home');
    }
}
