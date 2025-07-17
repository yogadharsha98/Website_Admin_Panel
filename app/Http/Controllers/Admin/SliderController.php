<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    public function index()
    {

        $sliders = Slider::all();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create()
    {
        $sliders = Slider::all();
        return view('admin.slider.create', compact('sliders'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Slider store started.');

            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content_title' => 'nullable|string|max:255',
                'content_title_main' => 'nullable|string',
                'content_description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable', // <-- relaxed validation here
            ]);

            Log::info('Validation passed.', ['validated' => $validated]);

            // Define upload path relative to public
            $uploadPath = 'uploads/slider/';

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
            $slider = Slider::create([
                'title' => $validated['title'],
                'content_title' => $validated['content_title'],
                'content_title_main' => $validated['content_title_main'],
                'content_description' => $validated['content_description'],
                'image' => $uploadPath . $originalFileName, // store relative path
                'is_active' => $request->has('is_active') ? 1 : 0, // manually convert checkbox value
            ]);
            Log::info('Slider created in database.', ['slider_id' => $slider->id]);

            // Redirect to category index with success message
            return redirect()->route('admin.slider.index')
                ->with('success', 'Slider created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed.', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Exception caught during slider store.', [
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
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('Slider update started.', ['slider_id' => $id]);

            $slider = Slider::findOrFail($id);

            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content_title' => 'nullable|string|max:255',
                'content_title_main' => 'nullable|string',
                'content_description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'is_active' => 'nullable',
            ]);

            Log::info('Validation passed.', ['validated' => $validated]);

            $slider->title = $validated['title'];
            $slider->content_title = $validated['content_title'];
            $slider->content_title_main = $validated['content_title_main'];
            $slider->content_description = $validated['content_description'];
            $slider->is_active = $request->has('is_active') ? 1 : 0;

            // If a new image is uploaded
            if ($request->hasFile('image')) {
                $uploadPath = 'uploads/slider/';
                $fullUploadPath = public_path($uploadPath);

                if (!file_exists($fullUploadPath)) {
                    mkdir($fullUploadPath, 0755, true);
                    Log::info('Created upload directory.', ['path' => $fullUploadPath]);
                }

                $originalFileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '', $request->file('image')->getClientOriginalName());
                $request->file('image')->move($fullUploadPath, $originalFileName);
                Log::info('Image moved to upload directory.', ['path' => $fullUploadPath . $originalFileName]);

                // Delete old image if exists
                if ($slider->image && file_exists(public_path($slider->image))) {
                    unlink(public_path($slider->image));
                    Log::info('Old image deleted.', ['old_image' => $slider->image]);
                }

                $slider->image = $uploadPath . $originalFileName;
            }

            $slider->save();
            Log::info('Slider updated successfully.', ['slider_id' => $slider->id]);

            return redirect()->route('admin.slider.index')
                ->with('success', 'Slider updated successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed.', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Exception caught during slider update.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $slider = Slider::findOrFail($id);

            // Delete the image file from public folder if it exists
            if ($slider->image && file_exists(public_path($slider->image))) {
                unlink(public_path($slider->image));
            }

            $slider->delete();

            return redirect()->route('admin.slider.index')
                ->with('success', 'Slider deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting slider.', [
                'id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('admin.slider.index')
                ->with('error', 'An error occurred while deleting the slider.');
        }
    }

}
