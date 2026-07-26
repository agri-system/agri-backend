<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionLot
 * 
 * @property string $id
 * @property string $field_id
 * @property string $crop
 * @property string $lot_code
 * @property Carbon $creation_date
 * @property string $status
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Field $field
 * @property Collection|Harvest[] $harvests
 * @property Collection|Stock[] $stocks
 * @property Collection|Sale[] $sales
 * @property Collection|Distribution[] $distributions
 *
 * @package App\Models
 */
class ProductionLot extends Model
{
	protected $table = 'production_lots';
	public $incrementing = false;

	protected $casts = [
		'creation_date' => 'datetime'
	];

	protected $fillable = [
		'field_id',
		'crop',
		'lot_code',
		'creation_date',
		'status',
		'notes'
	];

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function harvests()
	{
		return $this->hasMany(Harvest::class, 'lot_id');
	}

	public function stocks()
	{
		return $this->hasMany(Stock::class, 'lot_id');
	}

	public function sales()
	{
		return $this->hasMany(Sale::class, 'lot_id');
	}

	public function distributions()
	{
		return $this->hasMany(Distribution::class, 'lot_id');
	}
}
