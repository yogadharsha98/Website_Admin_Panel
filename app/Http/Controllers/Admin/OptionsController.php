<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use App\Models\FieldsOption;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OptionsController extends Controller
{
    public function index($field_id)
    {
        // Fetch the field by ID
        $field = Field::findOrFail($field_id);

        // Retrieve any related options (if applicable)
        $options = $field->options ?? []; // Adjust based on your model relationships

        // Return the options view
        return view('admin.options.index', compact('field', 'options'));
    }

    public function create($field_id)
    {
        $field = Field::findOrFail($field_id);
        return view('admin.options.create', compact('field'));
    }

    public function store(Request $request, $field_id)
    {
        // Validate the form input
        $request->validate([
            'value' => 'required|string|max:255', // The 'value' field is required and should be a string
        ]);

        // Retrieve the field by its ID
        $field = Field::findOrFail($field_id);

        // Create a new FieldsOption instance
        $option = new FieldsOption();
        $option->field_id = $field->id; // Associate the field with the option
        $option->value = $request->input('value'); // Set the value from the form input

        // You can add additional logic for 'parent_id', 'lft', 'rgt', 'depth' if needed.
        // For example, if these fields are related to tree structure, you may assign them manually:
        // $option->parent_id = 0; // Or another logic for determining the parent_id.
        // $option->lft = 1; // Assuming left value for tree structure.
        // $option->rgt = 2; // Assuming right value for tree structure.
        // $option->depth = 1; // Depth level in a tree structure.

        // Save the FieldsOption to the database
        $option->save();

        // Redirect to the options index page with a success message
        return redirect()->route('admin.options.index', $field->id)
                         ->with('success', 'Option added successfully!');
    }

    public function edit($field_id, $option_id)
    {
        $field = Field::findOrFail($field_id);
        $option = FieldsOption::findOrFail($option_id);

        return view('admin.options.edit', compact('field', 'option'));
    }

    public function update(Request $request, $field_id, $option_id)
    {
        // Validate the form input
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        // Find the option by ID
        $option = FieldsOption::findOrFail($option_id);
        $option->value = $request->input('value');
        $option->save();

        // Redirect with success message
        return redirect()->route('admin.options.index', $field_id)
            ->with('success', 'Option updated successfully!');
    }

    public function destroy($field_id, $option_id)
    {
        // Find the option by ID and delete it
        $option = FieldsOption::findOrFail($option_id);
        $option->delete();

        // Redirect with success message
        return redirect()->route('admin.options.index', $field_id)
            ->with('success', 'Option deleted successfully!');
    }


}
