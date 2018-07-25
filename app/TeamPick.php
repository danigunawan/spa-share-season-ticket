<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TeamPick
 *
 * @mixin \Eloquent
 * @property int                     $id
 * @property int|null                $schedule_id
 * @property int                     $participant_id
 * @property int                     $team_id
 * @property string                  $pick_guid
 * @property \Carbon\Carbon|null     $picked_at
 * @property \Carbon\Carbon|null     $created_at
 * @property \Carbon\Carbon|null     $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereParticipantId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick wherePickGuid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick wherePickedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereScheduleId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereTeamId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TeamPick whereUpdatedAt( $value )
 * @property-read \App\Participant   $participant
 * @property-read \App\Team          $team
 * @property-read ParticipantTeam    $participant_extra
 * @property-read \App\Schedule|null $schedule
 * @property-read mixed $is_picking
 */
class TeamPick extends Model {
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates
		= [
			'created_at',
			'updated_at',
			'picked_at',
		];

	protected $table = 'team_picks';

	protected $hidden = [ 'id', 'participant_id', 'team_id', 'pick_guid' ];

	protected $appends = [ 'participant_extra', 'is_picking' ];

	public function team() {
		return $this->belongsTo( Team::class );
	}

	public function participant() {
		return $this->belongsTo( Participant::class );
	}

	public function schedule() {
		return $this->belongsTo( Schedule::class );
	}

	/**
	 * @return ParticipantTeam|Model|null|object
	 */
	public function getParticipantExtraAttribute() {
		return ParticipantTeam::where( 'team_id', $this->team_id )->where( 'participant_id', $this->participant_id )->first();
	}

	public function getIsPickingAttribute() {
		return ! empty( $this->pick_guid );
	}

}
