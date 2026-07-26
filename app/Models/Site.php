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
 * Class Site
 * 
 * @property string $id
 * @property string $name
 * @property string|null $location
 * @property float|null $area
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 * @property Collection|Field[] $fields
 * @property Collection|Expense[] $expenses
 * @property Collection|Stock[] $stocks
 * @property Collection|Sale[] $sales
 * @property Collection|Distribution[] $distributions
 *
 * @package App\Models
 */
class Site extends Model
{
	use HasUlids;

	protected $table = 'sites';
	public $incrementing = false;

	protected $casts = [
		'area' => 'float'
	];

	protected $fillable = [
		'name',
		'location',
		'area',
		'description'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_sites')
					->withPivot('id')
					->withTimestamps();
	}

	public function fields()
	{
		return $this->hasMany(Field::class);
	}

	public function expenses()
	{
		return $this->hasMany(Expense::class);
	}

	public function stocks()
	{
		return $this->hasMany(Stock::class);
	}

	public function sales()
	{
		return $this->hasMany(Sale::class);
	}

	public function distributions()
	{
		return $this->hasMany(Distribution::class, 'destination_site_id');
	}
}
