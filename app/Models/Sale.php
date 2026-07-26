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
 * Class Sale
 * 
 * @property string $id
 * @property string $lot_id
 * @property string $product_id
 * @property string $client_id
 * @property string $user_id
 * @property string $site_id
 * @property float $quantity
 * @property string $unit
 * @property float $unit_price
 * @property float $total_amount
 * @property Carbon $sale_date
 * @property string $payment_status
 * @property Carbon|null $due_date
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ProductionLot $production_lot
 * @property Product $product
 * @property Client $client
 * @property User $user
 * @property Site $site
 * @property Collection|Debt[] $debts
 *
 * @package App\Models
 */
class Sale extends Model
{
	use HasUlids;

	protected $table = 'sales';
	public $incrementing = false;

	protected $casts = [
		'quantity' => 'float',
		'unit_price' => 'float',
		'total_amount' => 'float',
		'sale_date' => 'datetime',
		'due_date' => 'datetime'
	];

	protected $fillable = [
		'lot_id',
		'product_id',
		'client_id',
		'user_id',
		'site_id',
		'quantity',
		'unit',
		'unit_price',
		'total_amount',
		'sale_date',
		'payment_status',
		'due_date',
		'notes'
	];

	public function production_lot()
	{
		return $this->belongsTo(ProductionLot::class, 'lot_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function site()
	{
		return $this->belongsTo(Site::class);
	}

	public function debts()
	{
		return $this->hasMany(Debt::class);
	}
}
