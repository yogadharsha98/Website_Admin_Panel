<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(['success' => true, 'data' => $categories], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $uploadPath = 'uploads/category/';
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $image->getClientOriginalName());
            $image->move(public_path($uploadPath), $imageName);

            $category = Category::create([
                'title' => $request->title,
                'image' => $uploadPath . $imageName,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);

            return response()->json(['success' => true, 'data' => $category], 201);
        } catch (\Exception $e) {
            Log::error('API Category store failed', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Category creation failed.'], 500);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            if ($request->hasFile('image')) {
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $uploadPath = 'uploads/category/';
                $image = $request->file('image');
                $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $image->getClientOriginalName());
                $image->move(public_path($uploadPath), $imageName);
                $category->image = $uploadPath . $imageName;
            }

            $category->title = $request->title;
            $category->is_active = $request->has('is_active') ? 1 : 0;
            $category->save();

            return response()->json(['success' => true, 'data' => $category], 200);
        } catch (\Exception $e) {
            Log::error('API Category update failed', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Category update failed.'], 500);
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        try {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $category->delete();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('API Category delete failed', ['message' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete category.'], 500);
        }
    }
}

