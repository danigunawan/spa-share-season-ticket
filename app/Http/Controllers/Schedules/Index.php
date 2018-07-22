<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Invokable;
use App\Schedule;
use Illuminate\Http\Request;

class Index extends Controller {
	use Invokable;

	/**
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke( Request $request ) {
		return Schedule::simplePaginate( $request->get( 'limit' ) );
	}
}
