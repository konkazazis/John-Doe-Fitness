<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Admin: create category
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $data['slug'] = Str::slug($data['name']);
        Category::create($data);

        return redirect()->route('admin.taxonomy')->with('success', 'Category created.');
    }

    // Admin: update category
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
        ]);

        $data['slug'] = Str::slug($data['name']);
        $category->update($data);

        return redirect()->route('admin.taxonomy')->with('success', 'Category updated.');
    }

    // Admin: delete category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.taxonomy')->with('success', 'Category deleted.');
    }
}
