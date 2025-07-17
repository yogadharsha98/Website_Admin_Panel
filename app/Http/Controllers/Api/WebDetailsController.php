<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class WebDetailsController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            return response()->json(['message' => 'Settings not found'], 404);
        }

        return response()->json(['data' => $setting], 200);
    }
}
