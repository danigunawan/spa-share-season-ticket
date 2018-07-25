<?php

namespace App\Listeners;

use App\Events\PickingStarted;
use App\Mail\ParticipantPickEmail;
use App\TeamPick;

class PickingStartedListener {
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
	 * @param  PickingStarted $event
	 *
	 * @return void
	 * @throws \Throwable
	 */
	public function handle( PickingStarted $event ) {
		\Log::debug( 'PickingStartedListener' );

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
