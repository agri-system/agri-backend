<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Expense
 * 
 * @property string $id
 * @property string $site_id
 * @property string|null $field_id
 * @property string|null $crop
 * @property string $category
 * @property string $description
 * @property float $amount
 * @property Carbon $expense_date
 * @property string $user_id
 * @property string|null $need_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Site $site
 * @property Field|null $field
 * @property User $user
 * @property AgriculturalNeed|null $agricultural_need
 *
 * @package App\Models
 */
class Expense extends Model
{
	protected $table = 'expenses';
	public $incrementing = false;

	protected $casts = [
		'amount' => 'float',
		'expense_date' => 'datetime'
	];

	protected $fillable = [
		'site_id',
		'field_id',
		'crop',
		'category',
		'description',
		'amount',
		'expense_date',
		'user_id',
		'need_id'
	];

	public function site()
	{
		return $this->belongsTo(Site::class);
	}

	public function field()
	{
		return $this->belongsTo(Field::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function agricultural_need()
	{
		return $this->belongsTo(AgriculturalNeed::class, 'need_id');
	}
}
