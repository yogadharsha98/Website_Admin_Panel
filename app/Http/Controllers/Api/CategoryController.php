<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::orderBy('id', 'DESC')->paginate(15));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('category', 'public');

        $category = Category::create([
            'title' => $request->title,
            'slug' => Str::slug($request->slug ?? $request->title),
            'is_active' => $request->is_active ? '1' : '0',
            'image' => $imagePath,
        ]);

        return response()->json(['message' => 'Category created', 'category' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->slug ?? $request->title),
            'is_active' => $request->is_active ? '1' : '0',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category', 'public');
        }

        $category->update($data);

        return response()->json(['message' => 'Category updated', 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted']);
    }
}

