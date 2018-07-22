<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantTeams extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'participant_teams',
			function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->integer( 'participant_id' )->unsigned();
				$table->integer( 'team_id' )->unsigned();
				$table->boolean( 'is_confirmed' )->default( false );
				$table->string( 'confirm_guid' )->unique();
				$table->dateTime( 'confirmed_at' )->nullable();
				$table->timestamps();
			} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'participant_teams' );
	}
}
