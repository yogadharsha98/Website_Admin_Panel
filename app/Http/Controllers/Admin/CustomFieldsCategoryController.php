<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryField;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomFieldsCategoryController extends Controller
{


    public function create(Field $field)
    {
        // Fetch categories with their related sub-categories
        $categories = Category::with('subCategories')->get();

        // Fetch category_fields data related to the specific field
        $categoryFields = CategoryField::with(['category', 'category.subCategories', 'field'])
            ->where('field_id', $field->id) // Filter by field_id
            ->get();

        // Pass data to the view
        return view('admin.custom-field-categories.create', compact('field', 'categories', 'categoryFields'));
    }

    public function store(Request $request)
    {
        // Extract category_id and sub_category_id from the submitted string
        $categorySubCategory = explode(':', $request->category_sub_category);
        $categoryId = $categorySubCategory[0];
        $subCategoryId = $categorySubCategory[1];

        // Save data to category_fields table
        CategoryField::create([
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'field_id' => $request->field_id, // Ensure that field_id is included here
        ]);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Data saved successfully');
    }

    public function edit($fieldId)
    {
        // Find the field by ID
        $field = CategoryField::findOrFail($fieldId);

        // Get categories and sub-categories to populate the dropdown
        $categories = Category::with('subCategories')->get();

        // Return the edit view with field data
        return view('admin.custom-field-categories.edit', compact('field', 'categories'));
    }

    // Function to update the category field
    public function update(Request $request, $id)
    {
        // Find the category field to be updated
        $categoryField = CategoryField::findOrFail($id);

        // Extract category_id and sub_category_id from the submitted string
        $categorySubCategory = explode(':', $request->category_sub_category);
        $categoryId = $categorySubCategory[0];
        $subCategoryId = $categorySubCategory[1];

        // Update the category field with the new values
        $categoryField->update([
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'field_id' => $request->field_id,
        ]);

        // Redirect back with success message
        return back()->with('success', 'Category Field updated successfully');
    }

public function destroy($id)
{
    // Find and delete the category field
    CategoryField::destroy($id);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Category Field deleted successfully');
}











}
