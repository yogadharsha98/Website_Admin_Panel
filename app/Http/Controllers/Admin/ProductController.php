<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryField;

class ProductController extends Controller
{
    public function index()
    {

        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function getSubcategories($categoryId)
    {
        $category = Category::with('subCategories')->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json($category->subCategories);
    }

    public function getFieldsByCategorySubcategory($categoryId, $subCategoryId)
    {
        $categoryFields = CategoryField::with(['field.options'])
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subCategoryId)
            ->get();

        return response()->json($categoryFields);
    }

    public function store()
    {

    }
}
