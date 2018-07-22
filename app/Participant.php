<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Participant
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Team[]     $teams
 * @mixin \Eloquent
 * @property int                                                           $id
 * @property string                                                        $email
 * @property string                                                        $guid
 * @property \Carbon\Carbon|null                                           $created_at
 * @property \Carbon\Carbon|null                                           $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereEmail( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereGuid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereUpdatedAt( $value )
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TeamPick[] $picks
 */
class Participant extends Model {
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates
		= [
			'created_at',
			'updated_at',
		];

	protected $table = 'participants';

	protected $hidden = [ 'id' ];

	public function teams() {
		return $this->belongsToMany(
			Team::class,
			'participant_teams',
			'participant_id',
			'team_id'
		);
	}

	public function picks() {
		return $this->hasMany( TeamPick::class );
	}

	public function toArray() {
		$attributes = $this->attributesToArray();
		$attributes = array_merge( $attributes, $this->relationsToArray() );

		// Detect if there is a pivot value and return that as the default value
		if ( isset( $attributes['pivot'] ) ) {
			$attributes['name']         = $attributes['pivot']['participant_name'];
			$attributes['confirmed_at'] = $attributes['pivot']['confirmed_at'];

			unset( $attributes['pivot'] );
		}


		return $attributes;
	}

}
