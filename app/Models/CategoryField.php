<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryField extends Model
{
    use HasFactory;
    protected $table = 'category_fields';

    public $timestamps = false;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

    protected $fillable = [
		'category_id',
        'sub_category_id',
		'field_id',
	];

    public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}

	public function field()
	{
		return $this->belongsTo(Field::class, 'field_id');
	}

}
