<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->get();
        return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'original_price' => 'required|numeric',
            'starting_price' => 'required|numeric',
            'ending_price' => 'required|numeric',
            'total_quantity' => 'required|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product = new Product($request->only([
                'category_id', 'sub_category_id', 'name', 'slug',
                'small_description', 'description',
                'meta_title', 'meta_description', 'meta_keyword',
                'original_price', 'starting_price', 'ending_price',
                'total_quantity',
            ]));

            $product->is_active = $request->has('is_active');
            $product->trending = $request->has('trending');
            $product->featured = $request->has('featured');
            $product->new_arrivals = $request->has('new_arrivals');
            $product->on_sale = $request->has('on_sale');

            if ($request->hasFile('main_image')) {
                $mainImage = $request->file('main_image');
                $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();
                $mainImage->move(public_path('uploads/product_main'), $mainImageName);
                $product->main_image = 'uploads/product_main/' . $mainImageName;
            }

            $product->save();

            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/product_img'), $imageName);
                    $product->images()->create([
                        'image_path' => 'uploads/product_img/' . $imageName,
                    ]);
                }
            }

            if ($request->filled('custom_fields')) {
                foreach ($request->custom_fields as $fieldId => $value) {
                    DB::table('product_custom_field_values')->insert([
                        'product_id' => $product->id,
                        'custom_field_id' => $fieldId,
                        'value' => is_array($value) ? json_encode($value) : $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('API product store failed', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to create product'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'original_price' => 'required|numeric',
            'starting_price' => 'required|numeric',
            'ending_price' => 'required|numeric',
            'total_quantity' => 'required|integer',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product->fill($request->only([
                'category_id', 'sub_category_id', 'name', 'slug',
                'small_description', 'description',
                'meta_title', 'meta_description', 'meta_keyword',
                'original_price', 'starting_price', 'ending_price',
                'total_quantity',
            ]));

            $product->is_active = $request->has('is_active');
            $product->trending = $request->has('trending');
            $product->featured = $request->has('featured');
            $product->new_arrivals = $request->has('new_arrivals');
            $product->on_sale = $request->has('on_sale');

            if ($request->hasFile('main_image')) {
                if ($product->main_image && File::exists(public_path($product->main_image))) {
                    File::delete(public_path($product->main_image));
                }

                $mainImage = $request->file('main_image');
                $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();
                $mainImage->move(public_path('uploads/product_main'), $mainImageName);
                $product->main_image = 'uploads/product_main/' . $mainImageName;
            }

            $product->save();

            // Additional images
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/product_img'), $imageName);
                    $product->images()->create(['image_path' => 'uploads/product_img/' . $imageName]);
                }
            }

            // Custom fields
            if ($request->filled('custom_fields')) {
                foreach ($request->custom_fields as $fieldId => $value) {
                    DB::table('product_custom_field_values')->updateOrInsert(
                        ['product_id' => $product->id, 'custom_field_id' => $fieldId],
                        ['value' => is_array($value) ? json_encode($value) : $value, 'updated_at' => now()]
                    );
                }
            }

            DB::commit();
            return response()->json(['message' => 'Product updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('API product update failed', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update product'], 500);
        }
    }

    public function destroy($id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        if ($product->main_image && File::exists(public_path($product->main_image))) {
            File::delete(public_path($product->main_image));
        }

        foreach ($product->images as $image) {
            if (File::exists(public_path($image->image_path))) {
                File::delete(public_path($image->image_path));
            }
            $image->delete();
        }

        DB::table('product_custom_field_values')->where('product_id', $product->id)->delete();
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
