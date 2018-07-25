<?php

namespace App\Http\Controllers\Teams;

use App\Events\TeamRegistered;
use App\Exceptions\FansFirstException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Http\Requests\CreateTeamRequest;
use App\Library\SnakeDraft\SnakeDraft;
use App\Library\SnakeDraft\SnakeDraftPick;
use App\Participant;
use App\Schedule;
use App\Team;
use App\TeamPick;
use Illuminate\Support\Facades\DB;

class Create extends Controller {
	use Invokable;

	/**
	 * @param CreateTeamRequest $request
	 *
	 * @return Team
	 * @throws FansFirstException
	 * @throws \Throwable
	 */
	public function __invoke( CreateTeamRequest $request ) {
		$seat_row     = $request->get( 'seat_row' );
		$seat_section = $request->get( 'seat_section' );

		$participant_names  = $request->get( 'participant_names' );
		$participant_emails = $request->get( 'participant_emails' );

		if ( count( $participant_names ) !== count( $participant_emails ) ) {
			throw new FansFirstException( 'Invalid Participant Details' );
		}

		$num_participant = count( $participant_names );

		$team = new Team();

		DB::transaction( function () use ( $seat_row, $seat_section, $participant_emails, $participant_names, &$team ) {
			$participants = collect();

			$team->guid         = str_random( 20 );
			$team->is_complete  = false;
			$team->is_picking   = false;
			$team->seat_row     = $seat_row;
			$team->seat_section = $seat_section;

			foreach ( $participant_emails as $key => $participant_email ) {
				$participant = Participant::where( 'email', '=', $participant_email )->first();
				if ( ! $participant ) {
					$participant        = new Participant();
					$participant->email = $participant_email;
					$participant->guid  = str_random( 20 );
					$participant->save();

				}

				$participant->name = $participant_names[ $key ];

				$participants->push( $participant );
			}

			$team->leader_id = $participants->first()->id;
			$team->save();

			$participants_sync = $participants->mapWithKeys( function ( $participant ) {
				return [
					$participant->id => [
						'participant_name' => $participant->name,
						'is_confirmed'     => false,
						'confirm_guid'     => str_random( 20 ),
					],
				];
			} );
			$team->participants()->sync( $participants_sync );

			// snake drafting
			$snakeDraftPicks        = [];
			$snakeDraftParticipants = [];
			$schedules              = Schedule::all();
			foreach ( $schedules as $schedule ) {
				$snakeDraftPicks[] = new SnakeDraftPick( $schedule->id, $schedule->name );
			}

			$shuffledParticipants = $participants->shuffle();
			foreach ( $shuffledParticipants as $participant ) {
				$snakeDraftParticipants[] = new \App\Library\SnakeDraft\Participant( $participant->id, $participant->email );
			}

			$snakeDrafter = new SnakeDraft( $snakeDraftParticipants, $snakeDraftPicks );
			$snakeDrafter->initiateRandomDraft();

			$rounds = $snakeDrafter->getRounds();

			foreach ( $rounds as $round ) {
				$picks = $round->getParticipantPicks();
				foreach ( $picks as $pick ) {
					$teamPick = new TeamPick();
					$teamPick->team()->associate( $team );
					$teamPick->participant()->associate( $pick->getParticipant()->getId() );
					$teamPick->pick_guid = null;
					$teamPick->save();

				}
			}

			event( new TeamRegistered( $team ) );
		} );


		return $team;

	}
}
