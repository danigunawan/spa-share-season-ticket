<?php

namespace App\Http\Controllers\Teams;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Team;

class Picks extends Controller {
	use Invokable;

	/**
	 * @param string $guid
	 *
	 * @return Team
	 */
	public function __invoke( string $guid ) {
		return Team::whereGuid( $guid )->firstOrFail()->picks;

	}
}
