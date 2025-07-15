<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'slug',
        'small_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'original_price',
        'starting_price',
        'ending_price',
        'total_quantity',
        'is_active',
        'trending',
        'featured',
        'new_arrivals',
        'on_sale',
        'main_image',
    ];

    // Relationship: A product has many product images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if (empty($product->slug) && !empty($product->name)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

}
