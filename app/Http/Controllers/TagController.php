<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    // Admin: create tag
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $data['slug'] = Str::slug($data['name']);
        Tag::create($data);

        return redirect()->route('admin.taxonomy')->with('success', 'Tag created.');
    }

    // Admin: update tag
    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $data['slug'] = Str::slug($data['name']);
        $tag->update($data);

        return redirect()->route('admin.taxonomy')->with('success', 'Tag updated.');
    }

    // Admin: delete tag
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.taxonomy')->with('success', 'Tag deleted.');
    }
}
