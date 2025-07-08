<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CustomFieldsController extends Controller
{
    public function index()
{
    // Fetch all custom fields
    $fields = Field::all(); // You can add any necessary filters here
    // Pass the fields to the view
    return view('admin.custom-field.index', compact('fields'));
}

    public function create()
    {
        $fieldTypes = Field::fieldTypes();  // Get field types
        return view('admin.custom-field.create',compact('fieldTypes'));
    }

    public function store(Request $request)
    {
        // Log the request data
        Log::info('Storing a custom field', ['request_data' => $request->all()]);

        // Validate the form data
        $request->validate([
            'name'          => 'required|string|max:255',
            'type'          => 'required|in:' . implode(',', array_keys(Field::fieldTypes())), // Ensure selected type is valid
            'max'           => 'nullable|integer|min:1', // Field length (max) is optional but must be a valid integer
            'default_value' => 'nullable|string', // Default value is optional
            'required'      => 'nullable|boolean', // Required is optional but boolean
            'active'        => 'nullable|boolean', // Active is optional but boolean
        ]);

        Log::info('Validation passed for creating custom field');

        // Store the custom field in the database
        $field = new Field();
        $field->name = $request->input('name');
        $field->type = $request->input('type');
        $field->max = $request->input('max', 255); // Default value for max if not provided
        $field->default_value = $request->input('default_value');
        $field->required = $request->has('required') ? true : false; // Checkbox for 'required' field
        $field->active = $request->has('active') ? true : false; // Checkbox for 'active' field
        $field->belongs_to = 'posts'; // Set the default value for 'belongs_to' field

        // Log field data before saving
        Log::info('Saving custom field', ['field_data' => $field->toArray()]);

        $field->save();

        // Log success message
        Log::info('Custom field saved successfully', ['field_id' => $field->id]);

        // Redirect to index page with success message
        return redirect()->route('admin.custom-field.index')->with('success', 'Custom field added successfully.');
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $fieldTypes = Field::fieldTypes();  // Get field types
        return view('admin.custom-field.edit', compact('field','fieldTypes'));
    }

    public function update(Request $request, $id)
    {
        // Log the request data
        Log::info('Updating custom field', ['request_data' => $request->all(), 'field_id' => $id]);

        // Validate the form data
        $request->validate([
            'name'          => 'required|string|max:255',
            'type'          => 'required|in:' . implode(',', array_keys(Field::fieldTypes())), // Ensure selected type is valid
            'max'           => 'nullable|integer|min:1', // Field length (max) is optional but must be a valid integer
            'default_value' => 'nullable|string', // Default value is optional
            'required'      => 'nullable|boolean', // Required is optional but boolean
            'active'        => 'nullable|boolean', // Active is optional but boolean
        ]);

        // Find the field to update
        $field = Field::findOrFail($id);

        // Update the field with the request data
        $field->name = $request->input('name');
        $field->type = $request->input('type');
        // $field->max = $request->input('max', 255); // Default value for max if not provided
        $field->default_value = $request->input('default_value');
        $field->required = $request->has('required') ? true : false; // Checkbox for 'required' field
        $field->active = $request->has('active') ? true : false; // Checkbox for 'active' field

        // Log the updated data before saving
        Log::info('Saving updated custom field', ['field_data' => $field->toArray()]);

        // Save the changes
        $field->save();

        // Log success message
        Log::info('Custom field updated successfully', ['field_id' => $field->id]);

        // Redirect to index page with success message
        return redirect()->route('admin.custom-field.index')->with('success', 'Custom field updated successfully.');
    }

    public function destroy($id)
    {
        // Find the Membership Package by ID
        $field = Field::find($id);

        // Check if the package exists
        if ($field) {
            // Delete the membership package
            $field->delete();

            // Return a success message and redirect
            return redirect()->back()->with('success', 'Field deleted successfully');
        }

        // If the package doesn't exist, return an error message
        return redirect()->route('custom-field.index')->with('error', 'Field not found');
    }

    public function updateStatus(Request $request, $field_id)
    {
        // Find the field by ID
        $field = Field::findOrFail($field_id);

        // Update the active status
        $field->active = $request->input('active');
        $field->save();

        // Return response
        return response()->json(['success' => true]);
    }

}
