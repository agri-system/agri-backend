<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AgriculturalNeed
 * 
 * @property string $id
 * @property string $field_id
 * @property string $crop
 * @property string $category
 * @property string $description
 * @property float|null $estimated_quantity
 * @property float|null $estimated_cost
 * @property Carbon|null $planned_date
 * @property string $priority
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Field $field
 * @property Collection|Expense[] $expenses
 *
 * @package App\Models
 */
class AgriculturalNeed extends Model
{
	use HasUlids;

	protected $table = 'agricultural_needs';
	public $incrementing = false;

	protected $casts = [
		'estimated_quantity' => 'float',
		'estimated_cost' => 'float',
		'planned_date' => 'datetime'
	];

	protected $fillable = [
		'field_id',
		'crop',
		'category',
		'description',
		'estimated_quantity',
		'estimated_cost',
		'planned_date',
		'priority',
		'status'
	];

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class, 'need_id');
	}
}
