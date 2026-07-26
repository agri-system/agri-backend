<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPermission
 * 
 * @property string $id
 * @property string $user_id
 * @property string $permission_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Permission $permission
 *
 * @package App\Models
 */
class UserPermission extends Model
{
	protected $table = 'user_permission';
	public $incrementing = false;

	protected $fillable = [
		'user_id',
		'permission_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
