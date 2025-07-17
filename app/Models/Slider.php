<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $fillable = ['title', 'slug','content_title','content_title_main','content_description', 'image', 'is_active'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($slider) {
            $slider->slug = Str::slug($slider->title);
        });

        static::updating(function ($slider) {
            $slider->slug = Str::slug($slider->title);
        });
    }

}
