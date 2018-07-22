<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'seat_row'             => 'required',
			'seat_section'         => 'required',
			'participant_names'    => 'required|array',
			'participant_emails'   => 'required|array',
			'participant_names.*'  => 'required',
			'participant_emails.*' => 'required|email|distinct',
		];
	}
}
