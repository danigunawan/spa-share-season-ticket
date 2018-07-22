<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ParticipantTeam
 *
 * @property-read \App\Participant $participant
 * @property-read \App\Team        $team
 * @mixin \Eloquent
 * @property int                   $id
 * @property int                   $participant_id
 * @property int                   $team_id
 * @property int                   $is_confirmed
 * @property string                $confirm_guid
 * @property \Carbon\Carbon|null   $confirmed_at
 * @property \Carbon\Carbon|null   $created_at
 * @property \Carbon\Carbon|null   $updated_at
 * @property string                $participant_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereConfirmGuid( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereConfirmedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereIsConfirmed( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereParticipantId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereParticipantName( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereTeamId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ParticipantTeam whereUpdatedAt( $value )
 */
class ParticipantTeam extends Model {
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates
		= [
			'created_at',
			'updated_at',
			'confirmed_at',
		];

	protected $table = 'participant_teams';

	protected $hidden = [ 'id', 'participant_id', 'team_id', 'confirm_guid' ];

	public function team() {
		return $this->belongsTo( Team::class );
	}

	public function participant() {
		return $this->belongsTo( Participant::class );
	}
}
