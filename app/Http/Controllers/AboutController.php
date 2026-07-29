<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        // Return the home view with the account details
        return view('layouts.about');
    }
}
