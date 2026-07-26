<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property string $id
 * @property string $name
 * @property string|null $category
 * @property string $default_unit
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Stock[] $stocks
 * @property Collection|Sale[] $sales
 * @property Collection|Distribution[] $distributions
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';
	public $incrementing = false;

	protected $fillable = [
		'name',
		'category',
		'default_unit',
		'description'
	];

	public function stocks()
	{
		return $this->hasMany(Stock::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function distributions()
	{
		return $this->hasMany(Distribution::class);
	}
}
