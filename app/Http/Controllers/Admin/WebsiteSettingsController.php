<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;



class WebsiteSettingsController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.website_settings.index', compact('setting'));
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        // BASIC INFO
        'website_name' => 'nullable|string|max:255',
        'website_url' => 'nullable|url|max:255',
        'page_title' => 'nullable|string|max:255',
        'meta_keyword' => 'nullable|string',
        'meta_description' => 'nullable|string',

        // CONTACT / LOCATION
        'address' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'google_map_url' => 'nullable|url',

        'phone1' => 'nullable|string|max:30',
        'phone2' => 'nullable|string|max:30',
        'email1' => 'nullable|email|max:255',
        'email2' => 'nullable|email|max:255',

        // SOCIAL
        'facebook' => 'nullable|url|max:255',
        'twitter' => 'nullable|url|max:255',
        'instagram' => 'nullable|url|max:255',
        'youtube' => 'nullable|url|max:255',

        // FOOTER
        'add_info' => 'nullable|string',
        'copy_right_txt' => 'nullable|string|max:255',
        'copyright_date' => 'nullable|date',
        'footer_url' => 'nullable|url',

        // IMAGES
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'footer_img_1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'footer_img_2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'footer_img_3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'footer_img_4' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'footer_img_5' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $uploadIfPresent = function ($field) use ($request, &$validated) {
        if ($request->hasFile($field)) {
            $path = $request->file($field)->store("uploads/settings", "public");
            $validated[$field] = $path;
        }
    };

    foreach (['image', 'footer_img_1', 'footer_img_2', 'footer_img_3', 'footer_img_4', 'footer_img_5'] as $imgField) {
        $uploadIfPresent($imgField);
    }

    try {
        $setting = Setting::first(); // Assuming only ONE row

        if ($setting) {
            $setting->update($validated);
        } else {
            $setting = Setting::create($validated);
        }

        return redirect()
            ->back()
            ->with('success', 'Settings saved successfully!');
    } catch (\Exception $e) {
        // Log the error if needed: Log::error($e->getMessage());
        return redirect()
            ->back()
            ->with('failure', 'Something went wrong while saving settings. Please try again.');
    }
}


}
