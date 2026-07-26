<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionCalendar
 * 
 * @property string $id
 * @property string $field_id
 * @property string $crop
 * @property string $stage
 * @property Carbon $planned_date
 * @property string $status
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Field $field
 *
 * @package App\Models
 */
class ProductionCalendar extends Model
{
	protected $table = 'production_calendar';
	public $incrementing = false;

	protected $casts = [
		'planned_date' => 'datetime'
	];

	protected $fillable = [
		'field_id',
		'crop',
		'stage',
		'planned_date',
		'status',
		'notes'
	];

	public function field()
	{
		return $this->belongsTo(Field::class);
	}
}
