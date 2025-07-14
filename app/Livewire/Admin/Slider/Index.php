<?php

namespace App\Livewire\Admin\Slider;

use App\Models\Slider;
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
        $sliders = Slider::orderBy('id', 'DESC')->paginate(15);
        return view('livewire.admin.slider.index', ['sliders' => $sliders])
            ->extends('layouts.admin')
            ->section('content');
    }

    public $title, $slug, $content_title, $content_title_main, $content_description, $image, $slider_id;
    public $is_active = true;

    public function mount($slider = null)
    {
        if ($slider) {
            $this->slider_id = $slider->id;
            $this->title = $slider->title;
            $this->slug = $slider->slug;
            $this->content_title = $slider->content_title;
            $this->content_title_main = $slider->content_title_main;
            $this->content_description = $slider->content_description;
            $this->is_active = $slider->is_active;
        } else {
            // Default values for a new category
            $this->title = '';
            $this->slug = '';
            $this->content_title = '';
            $this->content_title_main = '';
            $this->content_description = '';
            $this->is_active = true;
        }
    }

    public function storeSlider()
    {
        // Validate the inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'content_title' => 'nullable|string|max:255',
            'content_title_main' => 'nullable|string|max:255',
            'content_description' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Specify the upload path
        $uploadPath = 'slider/';

        // Get the original filename from the uploaded image
        $originalFileName = $this->image->getClientOriginalName();

        // Move the file to the specified directory with the original filename
        $this->image->storeAs($uploadPath, $originalFileName, 'public'); // Specify 'public' disk

        // Create the slider in the database with the image path
        Slider::create([
            'title' => $this->title,
            'slug' => Str::slug($this->slug), // Create a slug from the title
            'content_title' => $this->content_title,
            'content_title_main' => $this->content_title_main,
            'content_description' => $this->content_description,
            'is_active' => $this->is_active ? '1' : '0', // Convert boolean to string
            'image' => $uploadPath . $originalFileName, // Save the complete image path to the database
        ]);

        // Dispatch an alertify event after success
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Slider Added Successfully',
        ]);

        // Close the modal and reset the input fields
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editSlider(int $slider_id)
    {
        $this->slider_id = $slider_id;
        $slider = Slider::findOrFail($slider_id);
        $this->title = $slider->title;
        $this->slug = $slider->slug;
        $this->content_title = $slider->content_title;
        $this->content_title_main = $slider->content_title_main;
        $this->content_description = $slider->content_description;
        $this->image = $slider->image;
        $this->is_active = $slider->is_active;
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
            'content_title' => 'nullable|string',
            'content_title_main' => 'nullable|string',
            'content_description' => 'nullable|string',
            'image' => 'nullable|string',
            'is_active' => 'nullable',
        ];
    }

    public function resetInput()
    {
        $this->title = null;
        $this->slug = null;
        $this->content_title = null;
        $this->content_title_main = null;
        $this->content_description = null;
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

    public function updateSlider()
    {
        // Validate inputs
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'content_title' => 'nullable|string|max:255',
            'content_title_main' => 'nullable|string|max:255',
            'content_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure it's nullable
        ]);

        // Update the slug based on the title before saving
        $this->slug = Str::slug($this->title);

        // Logic for updating the category
        $slider = Slider::findOrFail($this->slider_id);

        // Prepare data for update
        $dataToUpdate = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content_title' => $this->content_title,
            'content_title_main' => $this->content_title_main,
            'content_description' => $this->content_description,
            'is_active' => $this->is_active ? '1' : '0',
        ];

        // Only update image if a new one is uploaded
        if ($this->image) {
            $uploadPath = 'slider/';
            $originalFileName = $this->image->getClientOriginalName();
            $this->image->storeAs($uploadPath, $originalFileName, 'public');
            $dataToUpdate['image'] = $uploadPath . $originalFileName;
        }

        // Update the category
        $slider->update($dataToUpdate);

        // Dispatch success alert
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Slider Updated Successfully',
        ]);

        // Close the modal and reset the input fields
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteSlider($slider_id)
    {
        // dd($category_id);
        $this->slider_id = $slider_id;

    }

    public function destroySlider()
    {
        $slider = slider::find($this->slider_id);
        $slider->delete();
        // Dispatch an alertify event after success
        $this->dispatch('alertify', [
            'type' => 'success',
            'message' => 'Slider Deleted Successfully',
        ]);
        $this->dispatch('close-modal');
    }

}
