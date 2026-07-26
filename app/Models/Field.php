<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Field
 * 
 * @property string $id
 * @property string $site_id
 * @property string $name
 * @property string|null $crop_type
 * @property string $status
 * @property float|null $area
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Site $site
 * @property Collection|ProductionLot[] $production_lots
 * @property Collection|ProductionActivity[] $production_activities
 * @property Collection|Harvest[] $harvests
 * @property Collection|ProductionCalendar[] $production_calendars
 * @property Collection|AgriculturalNeed[] $agricultural_needs
 * @property Collection|Expense[] $expenses
 * @property Collection|WorkerObjective[] $worker_objectives
 * @property Collection|WorkerIntervention[] $worker_interventions
 *
 * @package App\Models
 */
class Field extends Model
{
	protected $table = 'fields';
	public $incrementing = false;

	protected $casts = [
		'area' => 'float'
	];

	protected $fillable = [
		'site_id',
		'name',
		'crop_type',
		'status',
		'area'
	];

	public function site()
	{
		return $this->belongsTo(Site::class);
	}

	public function production_lots()
	{
		return $this->hasMany(ProductionLot::class);
	}

	public function production_activities()
	{
		return $this->hasMany(ProductionActivity::class);
	}

	public function harvests()
	{
		return $this->hasMany(Harvest::class);
	}

	public function production_calendars()
	{
		return $this->hasMany(ProductionCalendar::class);
	}

	public function agricultural_needs()
	{
		return $this->hasMany(AgriculturalNeed::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function worker_objectives()
	{
		return $this->hasMany(WorkerObjective::class);
	}

	public function worker_interventions()
	{
		return $this->hasMany(WorkerIntervention::class);
	}
}
