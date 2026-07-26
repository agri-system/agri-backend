<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockMovement
 * 
 * @property string $id
 * @property string $stock_id
 * @property string $movement_type
 * @property float $quantity
 * @property Carbon $movement_date
 * @property string $user_id
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Stock $stock
 * @property User $user
 *
 * @package App\Models
 */
class StockMovement extends Model
{
	protected $table = 'stock_movements';
	public $incrementing = false;

	protected $casts = [
		'quantity' => 'float',
		'movement_date' => 'datetime'
	];

	protected $fillable = [
		'stock_id',
		'movement_type',
		'quantity',
		'movement_date',
		'user_id',
		'reason'
	];

	public function stock()
	{
		return $this->belongsTo(Stock::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
