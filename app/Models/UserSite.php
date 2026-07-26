<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSite
 * 
 * @property string $id
 * @property string $user_id
 * @property string $site_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Site $site
 *
 * @package App\Models
 */
class UserSite extends Model
{
	protected $table = 'user_sites';
	public $incrementing = false;

	protected $fillable = [
		'user_id',
		'site_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function site()
	{
		return $this->belongsTo(Site::class);
	}
}
