<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParticipantName extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'participant_teams',
			function ( Blueprint $table ) {
				$table->string( 'participant_name' );
			} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'participant_teams',
			function ( Blueprint $table ) {
				$table->dropColumn( 'participant_name' );
			} );
	}
}
