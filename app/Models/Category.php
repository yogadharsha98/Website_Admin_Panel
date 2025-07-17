<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\CategoryField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';

    protected $fillable = ['title', 'slug', 'meta_title', 'meta_keyword', 'meta_description', 'image', 'is_active'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = Str::slug($category->title);
            $category->meta_title = $category->title . ' - Buy @ | Dealzbay.lk';
            $category->meta_keyword = implode(', ', explode(' ', strtolower($category->title)));
            $category->meta_description = 'Discover various ' . strtolower($category->title) . ' more products available on Dealzbay.lk. Find the best deals now!';
        });
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }


    public function fields()
    {
        return $this->belongsToMany(Field::class, 'category_field', 'category_id', 'field_id');
    }

    public function categoryFields()
    {
        return $this->hasMany(CategoryField::class, 'category_id');
    }

    public function products()
    {

        return $this->hasMany(Product::class,'category_id','id');
    }
}
