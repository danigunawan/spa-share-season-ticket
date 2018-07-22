<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Schedule;
use App\Team;

class AvailablePicks extends Controller {
	use Invokable;

	/**
	 * @param string $guid
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public function __invoke( string $guid ) {
		$picked = Team::whereGuid( $guid )->firstOrFail()->picks()->whereNotNull( 'schedule_id' )->pluck( 'schedule_id' );

		return Schedule::whereNotIn( 'id', $picked )->get();

	}
}
