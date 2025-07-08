<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';

    // Define the fillable fields for mass assignment
    protected $fillable = ['category_id', 'title', 'slug', 'is_active'];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($sub_category) {
            $sub_category->slug = Str::slug($sub_category->title);
        });
    }

    public function fields()
{
    return $this->hasMany(Field::class);
}
}
