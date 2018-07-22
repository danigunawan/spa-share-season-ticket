<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeams extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'teams',
			function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'guid' )->unique();
				$table->string( 'seat_row' );
				$table->string( 'seat_section' );
				$table->boolean( 'is_complete' )->default( false );
				$table->boolean( 'is_picking' )->default( false );
				$table->timestamps();
			} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'teams' );
	}
}
