<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function getSubcategories($categoryId)
    {
        $category = Category::with('subCategories')->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        return response()->json($category->subCategories);
    }

    public function getFieldsByCategorySubcategory($categoryId, $subCategoryId)
    {
        $categoryFields = CategoryField::with(['field.options'])
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subCategoryId)
            ->get();

        return response()->json($categoryFields);
    }

    public function store(Request $request)
    {
        Log::info('Product store started', ['request_data' => $request->all()]);

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

        try {
            $product = new Product();

            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->sub_category_id;
            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->small_description = $request->small_description;
            $product->description = $request->description;
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_keyword = $request->meta_keyword;
            $product->original_price = $request->original_price;
            $product->starting_price = $request->starting_price;
            $product->ending_price = $request->ending_price;
            $product->total_quantity = $request->total_quantity;
            $product->is_active = $request->has('is_active');
            $product->trending = $request->has('trending');
            $product->featured = $request->has('featured');
            $product->new_arrivals = $request->has('new_arrivals');
            $product->on_sale = $request->has('on_sale');

            // Main image upload
            if ($request->hasFile('main_image')) {
                $mainImage = $request->file('main_image');
                $mainImageName = time() . '_' . uniqid() . '.' . $mainImage->getClientOriginalExtension();
                $mainImage->move(public_path('uploads/product_main'), $mainImageName);
                $product->main_image = 'uploads/product_main/' . $mainImageName;
                Log::info('Main image uploaded', ['path' => $product->main_image]);
            }

            $saved = $product->save();

            Log::info('Product save status', ['saved' => $saved, 'product_id' => $product->id]);

            if (!$saved) {
                Log::error('Failed to save product');
                return redirect()->route('admin.product.create')->with('failure', 'Failed to save product.');
            }

            // Save additional product images
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/product_img'), $imageName);

                    $product->images()->create([
                        'image_path' => 'uploads/product_img/' . $imageName,
                    ]);
                    Log::info('Product additional image saved', ['image_path' => $imageName]);
                }
            }

            // Save custom fields
            if ($request->filled('custom_fields')) {
                foreach ($request->input('custom_fields') as $fieldId => $value) {
                    DB::table('product_custom_field_values')->insert([
                        'product_id' => $product->id,
                        'custom_field_id' => $fieldId,
                        'value' => is_array($value) ? json_encode($value) : $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    Log::info('Custom field saved', ['field_id' => $fieldId, 'value' => $value]);
                }
            }

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            Log::error('Product store failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return redirect()->route('admin.product.create')->with('failure', 'Error saving product.');
        }
    }

    public function edit(Product $product)
    {
        // Load categories + subcategories for dropdowns
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();

        return view('admin.product.edit', compact('product', 'categories', 'subCategories'));
    }

    public function Imagedestroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // Delete file from storage
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Product $product)
    {
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
            'product_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            Log::info('Starting product update', ['product_id' => $product->id]);

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

            // 🔄 MAIN IMAGE
            if ($request->hasFile('main_image')) {
                Log::info('New main image uploaded');

                // Delete old image
                if ($product->main_image && File::exists(public_path($product->main_image))) {
                    File::delete(public_path($product->main_image));
                    Log::info('Old main image deleted', ['path' => $product->main_image]);
                }

                $main = $request->file('main_image');
                $mainName = time() . '_' . uniqid() . '.' . $main->getClientOriginalExtension();
                $main->move(public_path('uploads/product_main'), $mainName);
                $product->main_image = 'uploads/product_main/' . $mainName;

                Log::info('New main image saved', ['path' => $product->main_image]);
            } else {
                Log::info('No new main image uploaded');
            }

            $product->save();
            Log::info('Product base info updated successfully');

            // 🗑️ DELETE selected gallery images
            if ($request->filled('delete_image_ids')) {
                Log::info('Gallery images marked for deletion', ['image_ids' => $request->delete_image_ids]);

                $ids = $request->delete_image_ids;
                $product->images()->whereIn('id', $ids)->get()->each(function ($img) {
                    Log::info('Deleting image', ['id' => $img->id, 'path' => $img->image_path]);

                    if (File::exists(public_path($img->image_path))) {
                        File::delete(public_path($img->image_path));
                        Log::info('Image file deleted from storage');
                    }
                    $img->delete();
                    Log::info('Image record deleted');
                });
            } else {
                Log::info('No gallery images selected for deletion');
            }

            Log::info('Files in request:', ['product_image' => $request->file('product_image')]);
            // ➕ ADD new gallery images
            if ($request->hasFile('product_image')) {
                foreach ($request->file('product_image') as $imgFile) {
                    $name = time() . '_' . uniqid() . '.' . $imgFile->getClientOriginalExtension();
                    $imgFile->move(public_path('uploads/product_img'), $name);
                    $product->images()->create(['image_path' => 'uploads/product_img/' . $name]);

                    Log::info('New gallery image uploaded', ['image_path' => 'uploads/product_img/' . $name]);
                }
            } else {
                Log::info('No new gallery images uploaded');
            }

            // 📝 CUSTOM FIELDS
            if ($request->filled('custom_fields')) {
                foreach ($request->custom_fields as $fieldId => $value) {
                    DB::table('product_custom_field_values')->updateOrInsert(
                        ['product_id' => $product->id, 'custom_field_id' => $fieldId],
                        [
                            'value' => is_array($value) ? json_encode($value) : $value,
                            'updated_at' => now(),
                        ]
                    );
                    Log::info('Custom field saved', ['field_id' => $fieldId, 'value' => $value]);
                }
            }

            DB::commit();

            Log::info('Product updated successfully');
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('failure', 'Error updating product.');
        }
    }

    public function destroy($id)
{
    try {
        $product = Product::findOrFail($id);

        // Delete main image
        if ($product->main_image && \File::exists(public_path($product->main_image))) {
            \File::delete(public_path($product->main_image));
            \Log::info('Main product image deleted', ['path' => $product->main_image]);
        }

        // Delete all related gallery images
        foreach ($product->images as $image) {
            if (\File::exists(public_path($image->image_path))) {
                \File::delete(public_path($image->image_path));
            }
            $image->delete();
        }

        // Delete custom fields (if applicable)
        \DB::table('product_custom_field_values')->where('product_id', $product->id)->delete();

        // Delete the product
        $product->delete();

        \Log::info('Product deleted successfully', ['product_id' => $id]);
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');

    } catch (\Exception $e) {
        \Log::error('Product deletion failed', [
            'product_id' => $id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->route('admin.product.index')->with('failure', 'Error deleting product.');
    }
}


}
