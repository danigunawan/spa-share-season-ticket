<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen
		= [
			'App\Events\TeamRegistered'           => [
				'App\Listeners\TeamRegisteredListener',
			],
			'App\Events\TeamParticipantConfirmed' => [
				'App\Listeners\TeamParticipantConfirmedListener',
			],
			'App\Events\ParticipantPicked'        => [
				'App\Listeners\ParticipantPickedListener',
			],
			'App\Events\PickingStarted'           => [
				'App\Listeners\PickingStartedListener',
			],
		];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot() {
		parent::boot();

		//
	}
}
