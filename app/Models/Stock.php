<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * 
 * @property string $id
 * @property string $site_id
 * @property string $product_id
 * @property string $lot_id
 * @property float $current_quantity
 * @property string $unit
 * @property float $alert_threshold
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Site $site
 * @property Product $product
 * @property ProductionLot $production_lot
 * @property Collection|StockMovement[] $stock_movements
 *
 * @package App\Models
 */
class Stock extends Model
{
	protected $table = 'stocks';
	public $incrementing = false;

	protected $casts = [
		'current_quantity' => 'float',
		'alert_threshold' => 'float'
	];

	protected $fillable = [
		'site_id',
		'product_id',
		'lot_id',
		'current_quantity',
		'unit',
		'alert_threshold'
	];

	public function site()
	{
		return $this->belongsTo(Site::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function production_lot()
	{
		return $this->belongsTo(ProductionLot::class, 'lot_id');
	}

	public function stock_movements()
	{
		return $this->hasMany(StockMovement::class);
	}
}
