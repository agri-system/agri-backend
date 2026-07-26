<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkerIntervention
 * 
 * @property string $id
 * @property string $worker_id
 * @property string $field_id
 * @property string $user_id
 * @property Carbon $intervention_date
 * @property string $work_type
 * @property time without time zone|null $start_time
 * @property time without time zone|null $end_time
 * @property bool $objective_met
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Worker $worker
 * @property Field $field
 * @property User $user
 *
 * @package App\Models
 */
class WorkerIntervention extends Model
{
	protected $table = 'worker_interventions';
	public $incrementing = false;

	protected $casts = [
		'intervention_date' => 'datetime',
		'start_time' => 'time without time zone',
		'end_time' => 'time without time zone',
		'objective_met' => 'bool'
	];

	protected $fillable = [
		'worker_id',
		'field_id',
		'user_id',
		'intervention_date',
		'work_type',
		'start_time',
		'end_time',
		'objective_met',
		'notes'
	];

	public function worker()
	{
		return $this->belongsTo(Worker::class);
	}

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
