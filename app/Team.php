<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Team
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Participant[] $participants
 * @mixin \Eloquent
 * @property int                                                              $id
 * @property string                                                           $guid
 * @property string                                                           $seat_row
 * @property string                                                           $seat_section
 * @property int                                                              $is_complete
 * @property int                                                              $is_picking
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property int                                                              $leader_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereGuid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereIsComplete( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereIsPicking( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereLeaderId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereSeatRow( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereSeatSection( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Team whereUpdatedAt( $value )
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TeamPick[]    $picks
 * @property-read mixed $is_all_confirmed
 */
class Team extends Model {
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

	protected $hidden  = [ 'id', 'leader_id' ];
	protected $appends = [ 'is_all_confirmed' ];

	protected $table = 'teams';

	public function participants() {
		return $this->belongsToMany(
			Participant::class,
			'participant_teams',
			'team_id',
			'participant_id'
		)->withPivot( [ 'participant_name', 'confirmed_at' ] );
	}

	public function picks() {
		return $this->hasMany( TeamPick::class )->with( [ 'participant', 'schedule' ] );
	}

	public function getIsAllConfirmedAttribute() {
		$notConfirmed = $this->participants()->whereNull( 'confirmed_at' )->first();
		if ( $notConfirmed ) {
			return false;
		}

		return true;
	}
}
