<?php

namespace App\Http\Controllers\Participants;

use App\Events\ParticipantPicked;
use App\Exceptions\FansFirstException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\ParticipantTeam;
use App\Schedule;
use App\TeamPick;
use Carbon\Carbon;

class Pick extends Controller {
	use Invokable;

	/**
	 * @param string $pick_guid
	 * @param string $schedule_id
	 *
	 * @return ParticipantTeam|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 * @throws FansFirstException
	 * @throws \Throwable
	 */
	public function __invoke( string $pick_guid, string $schedule_id ) {
		$team_pick = TeamPick::wherePickGuid( $pick_guid )->firstOrFail();
		$schedule  = Schedule::findOrFail( $schedule_id );

		if ( $team_pick->schedule || ! empty( $team_pick->picked_at ) ) {
			throw new FansFirstException( 'Already Picked Before' );
		}

		\DB::transaction( function () use ( &$team_pick, $schedule ) {
			/** @var Schedule $schedule */
			$team_pick->schedule_id = $schedule->id;
			$team_pick->picked_at   = Carbon::now();
			$team_pick->save();
			event( new ParticipantPicked( $team_pick->team ) );
		} );


		return $team_pick;

	}
}
