<?php

namespace App\Mail;

use App\Library\SnakeDraft\Participant;
use App\Library\SnakeDraft\SnakeDraft;
use App\Library\SnakeDraft\SnakeDraftParticipantPick;
use App\Library\SnakeDraft\SnakeDraftPick;
use App\Library\SnakeDraft\SnakeDraftRound;
use App\ParticipantTeam;
use App\Schedule;
use App\TeamPick;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Psy\Util\Json;

class ParticipantPickEmail extends Mailable {
	use Queueable, SerializesModels;
	/**
	 * @var TeamPick
	 */
	public $team_pick;

	/**
	 * Create a new message instance.
	 *
	 * @param TeamPick $team_pick
	 */
	public function __construct( TeamPick $team_pick ) {
		//
		$this->team_pick = $team_pick;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$participant_team = ParticipantTeam::whereParticipantId( $this->team_pick->participant_id )->whereTeamId( $this->team_pick->team_id )->firstOrFail();
		$num_participants = $this->team_pick->team->participants()->count();

		$team                 = $this->team_pick->team;
		$shuffled_participant = $team->picks()->limit( $num_participants );
		$team_picks           = $team->picks;
		$participant_id       = $this->team_pick->participant_id;

		$i = 1;
		$shuffled_participant->each( function ( $participant_pick ) use ( &$i, $participant_id ) {
			/** @var TeamPick $participant_pick */
			if ( $participant_pick->participant_id === $participant_id ) {
				return false;
			}
			$i ++;
		} );


		$snakeDraft        = new SnakeDraft( [], [] );
		$team_picks_chunks = $team_picks->chunk( $num_participants );

		$snakeDraftRounds = array();

		$current_participant_iterator = 1;
		$current_participant_orders   = collect();
		foreach ( $team_picks_chunks as $c => $team_picks_chunk ) {
			$participant_picks = [];
			foreach ( $team_picks_chunk as $key => $team_pick ) {
				/** @var TeamPick $team_pick */
				$participant = new Participant( $team_pick->participant_id, $team_pick->participant_extra->participant_name );
				if ( $team_pick->participant_id === $participant_id ) {
					$current_participant_orders->push( $current_participant_iterator );
				}

				$pick = null;
				if ( $team_pick->schedule_id ) {
					$schedule = $team_pick->schedule;
					$pick     = new SnakeDraftPick( $schedule->id, $schedule->name . ' ' . $schedule->time );
				}
				$participant_picks[] = new SnakeDraftParticipantPick( ( $key + 1 ), $participant, $pick );
				$current_participant_iterator ++;
			}

			$snakeDraftRounds[] = new SnakeDraftRound( ( $c + 1 ), ( $c + 1 ), $participant_picks );

		}

		$snakeDraft->setRounds( $snakeDraftRounds );

		$current_round = $snakeDraft->getNextIncompleteRound();
		$current_round->getNextParticipantToPick()->getParticipant()->getId();

		$current_participant_orders = $current_participant_orders->map( function ( $current_participant_order ) {
			return '#' . $current_participant_order;
		} );

		$pickeds = $team->picks()->whereNotNull( 'picked_at' )->get();

		$picked_iterator = 0;
		$pickeds_text    = $pickeds->map( function ( $picked ) use ( &$picked_iterator ) {
			$picked_iterator ++;

			/** @var TeamPick $picked */
			return [
				'iterator'         => $picked_iterator,
				'participant_name' => $picked->participant_extra->participant_name,
				'schedule_name'    => $picked->schedule->name,
				'schedule_time'    => $picked->schedule->time,
			];
		} );

		$picked = $team->picks()->whereNotNull( 'schedule_id' )->pluck( 'schedule_id' );

		$schedules      = Schedule::whereNotIn( 'id', $picked )->get();
		$team_pick      = $this->team_pick;
		$schedules_text = $schedules->map( function ( $schedule ) use ( $team_pick ) {
			return [
				'schedule_name' => $schedule->name,
				'schedule_time' => $schedule->time,
				'select_link'   => url( '/pick/' . $team_pick->pick_guid . '/' . $schedule->id ),
			];
		} );

		$view_data = [
			'url'         => url( '/' ),
			'first_line'  => 'Hi ' . $participant_team->participant_name,
			'second_line' => 'It’s time to make your selection in the draft for the seats you are sharing in section **' . $team->seat_section . '** row **' .
			                 $team->seat_row
			                 . '**. This is a snake draft (first pick in first round gets last pick in next round) ' . '' . 'and you were randomly assigned on ' .
			                 $current_participant_orders->first() . ' selection (as there are ' . $num_participants . ' participants in your draft you then have the #'
			                 . $current_round->getNextParticipantToPick()->getId() . ' selection in round #' .
			                 $current_round->getId() . '). Your selections are: ' . $current_participant_orders->implode( ', ' ),
			'pickeds'     => $pickeds_text,
			'schedules'   => $schedules_text,
			'team_url'    => url( '/team/' . $team->guid ),
		];

		if ( app()->isLocal() ) {
			\Log::debug( 'ParticipantPickEmail' );
			\Log::debug( Json::encode( $view_data ) );
		}

		return $this->markdown(
			'mail.participant.pick',
			$view_data
		)->subject( 'Flames season ticket draft - it’s your pick!' );
	}
}
