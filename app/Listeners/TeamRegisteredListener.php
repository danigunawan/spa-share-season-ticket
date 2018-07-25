<?php

namespace App\Listeners;

use App\Events\TeamRegistered;
use App\Mail\ParticipantConfirmationEmail;
use App\ParticipantTeam;

class TeamRegisteredListener {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  TeamRegistered $event
	 *
	 * @return void
	 */
	public function handle( TeamRegistered $event ) {
		\Log::debug( 'TeamRegisteredListener' );

		$team = $event->team;
		foreach ( $team->participants as $participant ) {
			$participant_team = ParticipantTeam::whereParticipantId( $participant->id )->whereTeamId( $team->id )->firstOrFail();
			$email            = $participant->email;
			\Log::debug( 'Send Email to ' . $email );

			\Mail::to( $email )
			     ->bcc( array( 'hendrawan@kuncoro.com' ) )
			     ->send( new ParticipantConfirmationEmail( $participant_team ) );
		}

	}
}
