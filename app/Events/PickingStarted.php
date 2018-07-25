<?php

namespace App\Events;

use App\Team;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PickingStarted {
	use Dispatchable, InteractsWithSockets, SerializesModels;
	/**
	 * @var Team
	 */
	public $team;

	/**
	 * Create a new event instance.
	 *
	 * @param Team $team
	 */
	public function __construct( Team $team ) {
		//
		$this->team = $team;
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
