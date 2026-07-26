<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Debt
 * 
 * @property string $id
 * @property string $sale_id
 * @property string $client_id
 * @property float $amount_due
 * @property Carbon $due_date
 * @property Carbon|null $reminder_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Sale $sale
 * @property Client $client
 *
 * @package App\Models
 */
class Debt extends Model
{
	protected $table = 'debts';
	public $incrementing = false;

	protected $casts = [
		'amount_due' => 'float',
		'due_date' => 'datetime',
		'reminder_date' => 'datetime'
	];

	protected $fillable = [
		'sale_id',
		'client_id',
		'amount_due',
		'due_date',
		'reminder_date',
		'status'
	];

	public function sale()
	{
		return $this->belongsTo(Sale::class);
	}

	public function client()
	{
		return $this->belongsTo(Client::class);
	}
}
