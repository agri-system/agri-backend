<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Distribution
 * 
 * @property string $id
 * @property string $lot_id
 * @property string $product_id
 * @property string $source_site_id
 * @property string $destination_site_id
 * @property string $user_id
 * @property float $quantity
 * @property string $unit
 * @property Carbon $distribution_date
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ProductionLot $production_lot
 * @property Product $product
 * @property Site $site
 * @property User $user
 *
 * @package App\Models
 */
class Distribution extends Model
{
	protected $table = 'distributions';
	public $incrementing = false;

	protected $casts = [
		'quantity' => 'float',
		'distribution_date' => 'datetime'
	];

	protected $fillable = [
		'lot_id',
		'product_id',
		'source_site_id',
		'destination_site_id',
		'user_id',
		'quantity',
		'unit',
		'distribution_date',
		'reason'
	];

	public function production_lot()
	{
		return $this->belongsTo(ProductionLot::class, 'lot_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function site()
	{
		return $this->belongsTo(Site::class, 'destination_site_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
