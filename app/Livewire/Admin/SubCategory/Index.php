<?php

namespace App\Livewire\Admin\SubCategory;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $categories = Category::all();
        $sub_categories = SubCategory::orderBy('id','DESC')->paginate(10);
        return view('livewire.admin.sub-category.index',['sub_categories' => $sub_categories,'categories' => $categories])
            ->extends('layouts.admin')
            ->section('content');
    }
    public $title, $slug, $sub_category_id,$category_id;
    public $is_active = true;

    public function mount($sub_category = null)
    {
        if ($sub_category) {
            $this->sub_category = $sub_category->category_id;
            $this->sub_category = $sub_category->id;
            $this->title = $sub_category->title;
            $this->slug = $sub_category->slug;
            $this->is_active = $sub_category->is_active;
            // Add other properties here if needed
        } else {
            // Default values for a new category
            $this->title = '';
            $this->slug = '';
            $this->is_active = true;
        }
    }

    public function storeSubCategory()
    {
        // Validate the inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Validate category ID
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // Create the category in the database with the image path
        SubCategory::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'slug' => Str::slug($this->slug), // Create a slug from the title
            'is_active' => $this->is_active ? '1' : '0', // Convert boolean to string
        ]);

        // Dispatch an alertify event after success
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Category Added Successfully',
        ]);

        // Close the modal and reset the input fields
        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function closeModal()
    {
        $this->resetInput();
    }

    public function OpenModal()
    {
        $this->resetInput();
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'category_id' => 'required|integer',
            'slug' => 'nullable|string',
            'is_active' => 'nullable',
        ];
    }

    public function resetInput()
    {
        $this->title = null;
        $this->slug = null;
        $this->status = null;
    }

    public function updatingPage()
    {
        $this->resetPage();
    }

    public function editSubCategory(int $sub_category_id)
    {
        $this->sub_category_id = $sub_category_id;
        $sub_category = SubCategory::findOrFail($sub_category_id);
        $this->title = $sub_category->title;
        $this->category_id = $sub_category->category_id;
        $this->slug = $sub_category->slug;
        $this->is_active = $sub_category->is_active;
    }

    public function updatedTitle($value)
    {
        // Optionally, you can still update the slug dynamically for display purposes
        $this->slug = Str::slug($value);
    }

    public function updateSubCategory()
    {
        // Validate inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // Update the slug based on the title before saving
        $this->slug = Str::slug($this->title);

        // Logic for updating the category
        $sub_category = SubCategory::findOrFail($this->sub_category_id);

        // Prepare data for update
        $dataToUpdate = [
            'title' => $this->title,
            'category_id' => $this->category_id,
            'slug' => $this->slug,
            'is_active' => $this->is_active ? '1' : '0',
        ];

        // Update the category
        $sub_category->update($dataToUpdate);

        // Dispatch success alert
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Category Updated Successfully',
        ]);

         // Close the modal and reset the input fields
         $this->dispatch('close-modal');
         $this->resetInput();
    }

    public function deleteSubCategory($sub_category_id)
    {
        // dd($category_id);
        $this->sub_category_id = $sub_category_id;

    }

    public function destroySubCategory()
    {
        $sub_category = SubCategory::find($this->sub_category_id);
        $sub_category->delete();
        // Dispatch an alertify event after success
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Sub-Category Deleted Successfully',
        ]);
        $this->dispatch('close-modal');
    }


}
