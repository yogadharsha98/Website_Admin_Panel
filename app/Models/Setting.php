<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'website_name',
        'image',
        'website_url',
        'page_title',
        'meta_keyword',
        'meta_description',
        'address',
        'latitude',
        'longitude',
        'google_map_url',
        'phone1',
        'phone2',
        'email1',
        'email2',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'add_info',
        'copy_right_txt',
        'copyright_date',
        'footer_url',
        'footer_img_1',
        'footer_img_2',
        'footer_img_3',
        'footer_img_4',
        'footer_img_5',
    ];
}
