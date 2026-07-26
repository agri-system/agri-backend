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
 * Class Client
 * 
 * @property string $id
 * @property string|null $user_id
 * @property string $name
 * @property string|null $contact
 * @property string|null $client_type
 * @property float $outstanding_balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Sale[] $sales
 * @property Collection|Debt[] $debts
 *
 * @package App\Models
 */
class Client extends Model
{
	use HasUlids;

	protected $table = 'clients';
	public $incrementing = false;

	protected $casts = [
		'outstanding_balance' => 'float'
	];

	protected $fillable = [
		'user_id',
		'name',
		'contact',
		'client_type',
		'outstanding_balance'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function debts()
	{
		return $this->hasMany(Debt::class);
	}
}
