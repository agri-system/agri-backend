<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Harvest
 * 
 * @property string $id
 * @property string $field_id
 * @property string $lot_id
 * @property string $user_id
 * @property Carbon $harvest_date
 * @property float|null $estimated_quantity
 * @property float $actual_quantity
 * @property string $unit
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Field $field
 * @property ProductionLot $production_lot
 * @property User $user
 *
 * @package App\Models
 */
class Harvest extends Model
{
	protected $table = 'harvests';
	public $incrementing = false;

	protected $casts = [
		'harvest_date' => 'datetime',
		'estimated_quantity' => 'float',
		'actual_quantity' => 'float'
	];

	protected $fillable = [
		'field_id',
		'lot_id',
		'user_id',
		'harvest_date',
		'estimated_quantity',
		'actual_quantity',
		'unit',
		'notes'
	];

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function production_lot()
	{
		return $this->belongsTo(ProductionLot::class, 'lot_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
