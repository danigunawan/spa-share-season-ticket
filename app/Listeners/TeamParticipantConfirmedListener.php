<?php

namespace App\Listeners;

use App\Events\PickingStarted;
use App\Events\TeamParticipantConfirmed;

class TeamParticipantConfirmedListener {
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
	 * @param  TeamParticipantConfirmed $event
	 *
	 * @return void
	 * @throws \Throwable
	 */
	public function handle( TeamParticipantConfirmed $event ) {
		\Log::debug( 'TeamParticipantConfirmedListener' );
		$participant_team = $event->participant_team;

		// check all already confirmed ?
		\Log::debug( $participant_team->team->is_all_confirmed ? 'ALL Confirmed' : 'Not ALL Confirmed' );
		if ( $participant_team->team->is_all_confirmed ) {
			\DB::transaction( function () use ( $participant_team ) {
				$participant_team->team->is_picking = 1;
				$participant_team->team->save();

				event( new PickingStarted( $participant_team->team ) );
			} );

		}
	}
}
