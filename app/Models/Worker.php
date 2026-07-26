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
 * Class Worker
 * 
 * @property string $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $contact
 * @property Carbon $hire_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|WorkerObjective[] $worker_objectives
 * @property Collection|WorkerIntervention[] $worker_interventions
 * @property Collection|Remuneration[] $remunerations
 *
 * @package App\Models
 */
class Worker extends Model
{
	use HasUlids;

	protected $table = 'workers';
	public $incrementing = false;

	protected $casts = [
		'hire_date' => 'datetime'
	];

	protected $fillable = [
		'last_name',
		'first_name',
		'contact',
		'hire_date',
		'status'
	];

	public function worker_objectives()
	{
		return $this->hasMany(WorkerObjective::class);
	}

	public function worker_interventions()
	{
		return $this->hasMany(WorkerIntervention::class);
	}

	public function remunerations()
	{
		return $this->hasMany(Remuneration::class);
	}
}
