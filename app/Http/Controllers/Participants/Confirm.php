<?php

namespace App\Http\Controllers\Participants;

use App\Events\TeamParticipantConfirmed;
use App\Exceptions\FansFirstException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\ParticipantTeam;
use Carbon\Carbon;

class Confirm extends Controller {
	use Invokable;

	/**
	 * @param string $confirm_guid
	 *
	 * @return ParticipantTeam|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 * @throws FansFirstException
	 * @throws \Throwable
	 */
	public function __invoke( string $confirm_guid ) {
		$paricipant_team = ParticipantTeam::whereConfirmGuid( $confirm_guid )->firstOrFail();

		if ( $paricipant_team->is_confirmed || ! empty( $paricipant_team->confirmed_at ) ) {
			throw new FansFirstException( 'Already Confirmed Before' );
		}

		\DB::transaction( function () use ( &$paricipant_team ) {
			$paricipant_team->is_confirmed = true;
			$paricipant_team->confirmed_at = Carbon::now();
			$paricipant_team->save();
			$paricipant_team->team->touch();

			event( new TeamParticipantConfirmed( $paricipant_team ) );
		} );


		return $paricipant_team;

	}
}
