<?php

namespace App\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $categories = Category::orderBy('id','DESC')->paginate(15);
        return view('livewire.admin.category.index', ['categories' => $categories])
            ->extends('layouts.admin')
            ->section('content');
    }

    public $title, $slug, $image, $category_id;
    public $is_active = true;

    public function mount($category = null)
    {
        if ($category) {
            $this->category_id = $category->id;
            $this->title = $category->title;
            $this->slug = $category->slug;
            $this->is_active = $category->is_active;
            // Add other properties here if needed
        } else {
            // Default values for a new category
            $this->title = '';
            $this->slug = '';
            $this->is_active = true;
        }
    }

    public function storeCategory()
    {
        // Validate the inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Specify the upload path
        $uploadPath = 'category/';

        // Get the original filename from the uploaded image
        $originalFileName = $this->image->getClientOriginalName();

        // Move the file to the specified directory with the original filename
        $this->image->storeAs($uploadPath, $originalFileName, 'public'); // Specify 'public' disk

        // Create the category in the database with the image path
        Category::create([
            'title' => $this->title,
            'slug' => Str::slug($this->slug), // Create a slug from the title
            'is_active' => $this->is_active ? '1' : '0', // Convert boolean to string
            'image' => $uploadPath . $originalFileName, // Save the complete image path to the database
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

    public function editCategory(int $category_id)
    {
        $this->category_id = $category_id;
        $category = Category::findOrFail($category_id);
        $this->title = $category->title;
        $this->slug = $category->slug;
        $this->meta_title = $category->meta_title;
        $this->meta_keyword = $category->meta_keyword;
        $this->meta_description = $category->meta_description;
        $this->image = $category->image;
        $this->is_active = $category->is_active;
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
            'slug' => 'nullable|string',
            'image' => 'nullable|string',
            'is_active' => 'nullable',
        ];
    }

    public function resetInput()
    {
        $this->title = null;
        $this->slug = null;
        $this->image = null;
        $this->is_active = null;
    }

    public function updatingPage()
    {
        $this->resetPage();
    }

    public function updatedTitle($value)
    {
        // Optionally, you can still update the slug dynamically for display purposes
        $this->slug = Str::slug($value);
    }

    public function updateCategory()
    {
        // Validate inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's nullable
        ]);

        // Update the slug based on the title before saving
        $this->slug = Str::slug($this->title);

        // Logic for updating the category
        $category = Category::findOrFail($this->category_id);

        // Prepare data for update
        $dataToUpdate = [
            'title' => $this->title,
            'slug' => $this->slug,
            'is_active' => $this->is_active ? '1' : '0',
        ];

        // Only update image if a new one is uploaded
        if ($this->image) {
            $uploadPath = 'category/';
            $originalFileName = $this->image->getClientOriginalName();
            $this->image->storeAs($uploadPath, $originalFileName, 'public');
            $dataToUpdate['image'] = $uploadPath . $originalFileName;
        }

        // Update the category
        $category->update($dataToUpdate);

        // Dispatch success alert
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Category Updated Successfully',
        ]);

         // Close the modal and reset the input fields
         $this->dispatch('close-modal');
         $this->resetInput();
    }

    public function deleteCategory($category_id)
    {
        // dd($category_id);
        $this->category_id = $category_id;

    }

    public function destroyCategory()
    {
        $category = Category::find($this->category_id);
        $category->delete();
        // Dispatch an alertify event after success
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Category Deleted Successfully',
        ]);
        $this->dispatch('close-modal');
    }

}
