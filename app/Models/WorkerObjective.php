<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerObjective
 * 
 * @property string $id
 * @property string $worker_id
 * @property int $week
 * @property int $year
 * @property string $work_type
 * @property float|null $target_quantity
 * @property string $field_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Worker $worker
 * @property Field $field
 *
 * @package App\Models
 */
class WorkerObjective extends Model
{
	use HasUlids;

	protected $table = 'worker_objectives';
	public $incrementing = false;

	protected $casts = [
		'week' => 'int',
		'year' => 'int',
		'target_quantity' => 'float'
	];

	protected $fillable = [
		'worker_id',
		'week',
		'year',
		'work_type',
		'target_quantity',
		'field_id',
		'status'
	];

	public function worker()
	{
		return $this->belongsTo(Worker::class);
	}

	public function field()
	{
		return $this->belongsTo(Field::class);
	}
}
