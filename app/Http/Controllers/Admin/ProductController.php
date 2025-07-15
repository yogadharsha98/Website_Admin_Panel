<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        return view('admin.product.index',compact('products'));
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

}
