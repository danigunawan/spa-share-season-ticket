<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Schedule
 *
 * @property-read mixed $time
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Schedule whereUpdatedAt($value)
 */
class Schedule extends Model {
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates
		= [
			'created_at',
			'updated_at',
			'time',
		];

	protected $table = 'schedules';

	public function getTimeAttribute($date)
	{
		return Carbon::parse($date)->format('l, d F h:i A');
	}
}
