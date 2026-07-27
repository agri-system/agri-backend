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
 * Class Permission
 * 
 * @property string $id
 * @property string $module
 * @property string $action
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Role[] $roles
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Permission extends Model
{
	use HasUlids;

	protected $table = 'permissions';
	public $incrementing = false;

	protected $fillable = [
		'module',
		'action',
		'description'
	];

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'role_permission')
					->using(RolePermission::class)
					->withPivot('id')
					->withTimestamps();
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_permission')
					->using(UserPermission::class)
					->withPivot('id')
					->withTimestamps();
	}
}
