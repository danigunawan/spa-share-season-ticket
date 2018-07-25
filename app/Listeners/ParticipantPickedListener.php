<?php

namespace App\Listeners;

use App\Events\ParticipantPicked;
use App\Mail\ParticipantPickEmail;
use App\TeamPick;

class ParticipantPickedListener {
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
	 * @param  ParticipantPicked $event
	 *
	 * @return void
	 * @throws \Throwable
	 */
	public function handle( ParticipantPicked $event ) {
		\Log::debug( 'ParticipantPickedListener' );

		$team = $event->team;

		/** @var TeamPick $next_pick */
		$next_pick = $team->picks()->whereNull( 'pick_guid' )->first();


		if ( $next_pick ) {
			\DB::transaction( function () use ( $next_pick ) {
				$next_pick->pick_guid = str_random( 20 );
				$next_pick->save();

				\Mail::to( $next_pick->participant->email )
				     ->bcc( array( 'hendrawan@kuncoro.com' ) )
				     ->send( new ParticipantPickEmail( $next_pick ) );
			} );

		}


	}
}
