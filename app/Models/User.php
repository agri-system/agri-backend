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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property string $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $username
 * @property string $email
 * @property string|null $phone
 * @property Carbon|null $email_verified_at
 * @property string|null $avatar_path
 * @property string|null $password
 * @property string $role_id
 * @property string $status
 * @property string $platform_access
 * @property string|null $activation_token
 * @property Carbon|null $activation_token_expires_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
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
    use HasApiTokens, HasFactory, Notifiable, HasUlids, SoftDeletes;

	protected $table = 'users';
	public $incrementing = false;

	protected $fillable = [
		'last_name',
		'first_name',
		'username',
		'email',
		'phone',
		'email_verified_at',
		'avatar_path',
		'password',
		'role_id',
		'status',
		'platform_access',
		'activation_token',
		'activation_token_expires_at',
		'remember_token'
	];

	protected $hidden = [
		'password',
		'remember_token',
		'activation_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'activation_token_expires_at' => 'datetime',
	];

	protected $appends = [
		'avatar_url',
	];

	public function getAvatarUrlAttribute(): ?string
	{
		return $this->avatar_path ? Storage::disk('public')->url($this->avatar_path) : null;
	}

	/**
	 * Whether this user is allowed to log in from the given platform ("web" or "mobile").
	 */
	public function hasPlatformAccess(string $platform): bool
	{
		return $this->platform_access === 'both' || $this->platform_access === $platform;
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'user_permission')
					->using(UserPermission::class)
					->withPivot('id')
					->withTimestamps();
	}

	public function sites()
	{
		return $this->belongsToMany(Site::class, 'user_sites')
					->using(UserSite::class)
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
