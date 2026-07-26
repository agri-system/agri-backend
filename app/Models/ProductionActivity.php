<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionActivity
 * 
 * @property string $id
 * @property string $field_id
 * @property string $user_id
 * @property string $activity_type
 * @property Carbon $activity_date
 * @property string|null $details
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Field $field
 * @property User $user
 *
 * @package App\Models
 */
class ProductionActivity extends Model
{
	use HasUlids;

	protected $table = 'production_activities';
	public $incrementing = false;

	protected $casts = [
		'activity_date' => 'datetime'
	];

	protected $fillable = [
		'field_id',
		'user_id',
		'activity_type',
		'activity_date',
		'details',
		'notes'
	];

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
