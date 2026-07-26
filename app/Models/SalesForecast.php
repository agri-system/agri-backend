<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesForecast
 * 
 * @property string $id
 * @property string $crop
 * @property int $month
 * @property int $year
 * @property float|null $planned_quantity
 * @property float $forecasted_revenue
 * @property float $actual_revenue
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SalesForecast extends Model
{
	protected $table = 'sales_forecasts';
	public $incrementing = false;

	protected $casts = [
		'month' => 'int',
		'year' => 'int',
		'planned_quantity' => 'float',
		'forecasted_revenue' => 'float',
		'actual_revenue' => 'float'
	];

	protected $fillable = [
		'crop',
		'month',
		'year',
		'planned_quantity',
		'forecasted_revenue',
		'actual_revenue'
	];
}
