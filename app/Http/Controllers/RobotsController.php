<?php

namespace App\Http\Controllers;

class RobotsController extends Controller
{
    public function index()
    {
        return response()
            ->view('robots')
            ->header('Content-Type', 'text/plain');
    }
}
