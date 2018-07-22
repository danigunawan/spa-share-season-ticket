<?php

namespace App\Exceptions;

use Exception;

class FansFirstException extends Exception {
	/**
	 * Render the exception as an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render( $request ) {
		if ( $request->isJson() ) {
			return response()->json(
				[
					'errors'  => array(
						'error' => $this->getMessage(),
					),
					'message' => $this->getMessage(),
				]
				,
				422
			);
		}


		return response()->make( $this->getMessage(), 422 );
	}
}
