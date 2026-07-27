<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property string $id
 * @property string $last_name
 * @property string $first_name
 * @property string $username
 * @property string $password
 * @property string $role_id
 * @property string $status
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Role $role
 * @property Collection|Permission[] $permissions
 * @property Collection|Site[] $sites
 * @property Collection|Client[] $clients
 * @property Collection|ProductionActivity[] $production_activities
 * @property Collection|Harvest[] $harvests
 * @property Collection|Expense[] $expenses
 * @property Collection|StockMovement[] $stock_movements
 * @property Collection|Sale[] $sales
 * @property Collection|Distribution[] $distributions
 * @property Collection|WorkerIntervention[] $worker_interventions
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

	protected $table = 'users';
	public $incrementing = false;

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'last_name',
		'first_name',
		'username',
		'password',
		'role_id',
		'status',
		'remember_token'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'user_permission')
					->withPivot('id')
					->withTimestamps();
	}

	public function sites()
	{
		return $this->belongsToMany(Site::class, 'user_sites')
					->withPivot('id')
					->withTimestamps();
	}

	public function clients()
	{
		return $this->hasMany(Client::class);
	}

	public function production_activities()
	{
		return $this->hasMany(ProductionActivity::class);
	}

	public function harvests()
	{
		return $this->hasMany(Harvest::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function stock_movements()
	{
		return $this->hasMany(StockMovement::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function distributions()
	{
		return $this->hasMany(Distribution::class);
	}

	public function worker_interventions()
	{
		return $this->hasMany(WorkerIntervention::class);
	}
}
