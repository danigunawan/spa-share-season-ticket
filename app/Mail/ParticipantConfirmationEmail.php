<?php

namespace App\Mail;

use App\ParticipantTeam;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipantConfirmationEmail extends Mailable {
	use Queueable, SerializesModels;
	/**
	 * @var ParticipantTeam
	 */
	private $participant_team;

	/**
	 * Create a new message instance.
	 *
	 * @param ParticipantTeam $participant_team
	 */
	public function __construct( ParticipantTeam $participant_team ) {
		//
		$this->participant_team = $participant_team;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {

		return $this->markdown(
			'mail.participant.confirmation',
			[
				'url'               => url( '/' ),
				'first_line'        => 'Congratulation you are one click away to confirm your participation!',
				'second_line'       => 'Get ready to pick your CALGARY FLAMES UPCOMING SEASON match',
				'participant_name'  => $this->participant_team->participant_name,
				'participant_email' => $this->participant_team->participant->email,
				'team_name'         => $this->participant_team->team->guid,
				'team_url'          => url( '/team/' . $this->participant_team->team->guid ),
				'num_participants'  => $this->participant_team->team->participants()->count(),
				'confirm_url'       => url( '/confirm/' . $this->participant_team->confirm_guid ),
			]
		)->subject( '[' . config( 'app.name' ) . '] Confirm!' );

	}
}
