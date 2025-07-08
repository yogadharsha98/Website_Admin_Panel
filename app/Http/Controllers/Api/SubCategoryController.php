<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')->orderBy('id', 'DESC')->paginate(10);
        return response()->json($subCategories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $subCategory = SubCategory::create([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'slug' => isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']),
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json($subCategory, 201);
    }

    public function show($id)
    {
        $subCategory = SubCategory::with('category')->findOrFail($id);
        return response()->json($subCategory);
    }

    public function update(Request $request, $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $subCategory->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'slug' => isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']),
            'is_active' => $validated['is_active'] ?? $subCategory->is_active,
        ]);

        return response()->json($subCategory);
    }

    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();

        return response()->json(['message' => 'SubCategory deleted successfully.']);
    }
}
