<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamPicks extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'team_picks',
			function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->integer( 'schedule_id' )->unsigned()->nullable();
				$table->integer( 'participant_id' )->unsigned();
				$table->integer( 'team_id' )->unsigned();
				$table->string( 'pick_guid' )->unique();
				$table->dateTime( 'picked_at' )->nullable();
				$table->timestamps();
			} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'team_picks' );
	}
}
