<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['upload' => 'required|image|max:4096']);

        $path = $request->file('upload')->store('post-images', 'public');

        return response()->json(['url' => Storage::url($path)]);
    }
}
