<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {

        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Category store started.');

            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable', // <-- relaxed validation here
            ]);

            Log::info('Validation passed.', ['validated' => $validated]);

            // Define upload path relative to public
            $uploadPath = 'uploads/category/';

            // Create directory if not exists
            $fullUploadPath = public_path($uploadPath);
            if (!file_exists($fullUploadPath)) {
                mkdir($fullUploadPath, 0755, true);
                Log::info('Created upload directory.', ['path' => $fullUploadPath]);
            }

            // Prepare unique filename
            $originalFileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $request->file('image')->getClientOriginalName());
            Log::info('Original file name prepared.', ['file' => $originalFileName]);

            // Move the uploaded image to the public folder
            $request->file('image')->move($fullUploadPath, $originalFileName);
            Log::info('Image moved to upload directory.', ['path' => $fullUploadPath . $originalFileName]);

            // Create the category record
            $category = Category::create([
                'title' => $validated['title'],
                'image' => $uploadPath . $originalFileName, // store relative path
                'is_active' => $request->has('is_active') ? 1 : 0, // manually convert checkbox value
            ]);
            Log::info('Category created in database.', ['category_id' => $category->id]);

            // Redirect to category index with success message
            return redirect()->route('admin.category.index')
                ->with('success', 'Category created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed.', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Exception caught during category store.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Category update started.', ['id' => $id]);

            $category = Category::findOrFail($id);

            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable',
            ]);

            Log::info('Validation passed for update.', ['validated' => $validated]);

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/category/';
                $fullUploadPath = public_path($uploadPath);

                if (!file_exists($fullUploadPath)) {
                    mkdir($fullUploadPath, 0755, true);
                    Log::info('Created upload directory.', ['path' => $fullUploadPath]);
                }

                $originalFileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $request->file('image')->getClientOriginalName());
                $request->file('image')->move($fullUploadPath, $originalFileName);
                Log::info('Image moved to upload directory.', ['path' => $fullUploadPath . $originalFileName]);

                $category->image = $uploadPath . $originalFileName;
            }

            // Update other fields
            $category->title = $validated['title'];
            $category->is_active = $request->has('is_active') ? 1 : 0;

            // Trigger the model boot logic by saving (this will re-generate slug/meta fields)
            $category->save();

            Log::info('Category updated in database.', ['category_id' => $category->id]);

            return redirect()->route('admin.category.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed on update.', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Exception during category update.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'An unexpected error occurred during update. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Delete the image file from public folder if it exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $category->delete();

            return redirect()->route('admin.category.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting category.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('admin.category.index')
                ->with('error', 'An error occurred while deleting the category.');
        }
    }

}
