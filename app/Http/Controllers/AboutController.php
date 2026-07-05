<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index()
    {
        // Return the home view with the account details
        return view('layouts.about');
    }
}

?>