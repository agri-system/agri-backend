<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Remuneration
 * 
 * @property string $id
 * @property string $worker_id
 * @property int $month
 * @property int $year
 * @property int $days_worked
 * @property int $objectives_met
 * @property float $calculated_amount
 * @property string $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Worker $worker
 *
 * @package App\Models
 */
class Remuneration extends Model
{
	protected $table = 'remunerations';
	public $incrementing = false;

	protected $casts = [
		'month' => 'int',
		'year' => 'int',
		'days_worked' => 'int',
		'objectives_met' => 'int',
		'calculated_amount' => 'float'
	];

	protected $fillable = [
		'worker_id',
		'month',
		'year',
		'days_worked',
		'objectives_met',
		'calculated_amount',
		'payment_status'
	];

	public function worker()
	{
		return $this->belongsTo(Worker::class);
	}
}
