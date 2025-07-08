<?php

namespace App\Models;

use App\Models\Category;
use App\Models\FieldsOption;
use App\Models\CategoryField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    use HasFactory;
    protected $table = 'fields';

    protected $primaryKey = 'id';

    /**
     * Indicates if the model should have timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'belongs_to',
        'name',
        'type',
        'max',
        'default_value',
        'required',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'belongs_to' => 'string',
        'name' => 'string',
        'type' => 'string',
        'max' => 'integer',
        'default_value' => 'string',
        'required' => 'boolean',
        'active' => 'boolean',
    ];

	public static function fieldTypes()
	{
		return [
			'text'              => 'Text',
			'textarea'          => 'Textarea',
			'checkbox'          => 'Checkbox',
			'checkbox_multiple' => 'Checkbox (Multiple)',
			'select'            => 'Select Box',
			'radio'             => 'Radio',
			'file'              => 'File',
			'url'               => 'URL',
			'number'            => 'Number',
			'date'              => 'Date',
			'date_time'         => 'Date Time',
			'date_range'        => 'Date Range',
			'video'             => 'Video (Youtube, Vimeo)',
		];
	}

    public function subcategory()
{
    return $this->belongsTo(SubCategory::class);
}

public function options()
	{
		return $this->hasMany(FieldsOption::class, 'field_id')
			->orderBy('lft')
			->orderBy('value');
	}

    public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_field', 'field_id', 'category_id');
	}

	public function categoryFields(){

		return $this->hasMany(CategoryField::class, 'field_id', 'id');
	}

}
