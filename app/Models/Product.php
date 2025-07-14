<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
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
        'created_by',
        'name',
        'slug',
        'small_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'original_price',
        'selling_price',
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

    // (Optional) Relationship: Product belongs to the user who created it
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
