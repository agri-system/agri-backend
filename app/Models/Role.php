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
 * Class Role
 * 
 * @property string $id
 * @property string $name
 * @property string|null $label
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 * @property Collection|Permission[] $permissions
 *
 * @package App\Models
 */
class Role extends Model
{
	use HasUlids;

	protected $table = 'roles';
	public $incrementing = false;

	protected $fillable = [
		'name',
		'label',
		'description'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'role_permission')
					->using(RolePermission::class)
					->withPivot('id')
					->withTimestamps();
	}
}
