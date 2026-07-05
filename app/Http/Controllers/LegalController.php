<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    public function impressum()
    {
        return view('layouts.impressum');
    }

    public function privacy()
    {
        return view('layouts.privacy');
    }
}
