<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Team;

class Participants extends Controller {
	use Invokable;

	/**
	 * @param string $guid
	 *
	 * @return Team|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function __invoke( string $guid ) {
		$team = Team::whereGuid( $guid )->with( [ 'participants' ] )->firstOrFail();

		return $team;

	}
}
