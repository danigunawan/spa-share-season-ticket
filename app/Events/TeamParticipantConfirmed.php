<?php

namespace App\Events;

use App\ParticipantTeam;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamParticipantConfirmed {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $participant_team;

	/**
	 * Create a new event instance.
	 *
	 * @param ParticipantTeam $participant_team
	 */
	public function __construct( ParticipantTeam $participant_team ) {
		$this->participant_team = $participant_team;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn() {
		return new PrivateChannel( 'channel-name' );
	}
}
