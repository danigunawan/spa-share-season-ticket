<?php

use Illuminate\Database\Seeder;

class Schedules extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$schedules = array(
			array( 'Edmonton', '2018-09-17 00:00:00' ),
			array( 'Vancouver', '2018-09-22 00:00:00' ),
			array( 'Winnipeg', '2018-09-24 00:00:00' ),
			array( 'San Jose', '2018-09-25 00:00:00' ),
			array( 'Vancouver', '2018-10-06 20:00:00' ),
			array( 'Boston', '2018-10-17 19:30:00' ),
			array( 'Nashville', '2018-10-19 19:00:00' ),
			array( 'Pittsburgh', '2018-10-25 19:00:00' ),
			array( 'Washington', '2018-10-27 14:00:00' ),
			array( 'Colorado', '2018-11-01 19:00:00' ),
			array( 'Chicago', '2018-11-03 20:00:00' ),
			array( 'Montreal', '2018-11-15 19:00:00' ),
			array( 'Edmonton', '2018-11-17 20:00:00' ),
			array( 'Vegas', '2018-11-19 19:00:00' ),
			array( 'Winnipeg', '2018-11-21 20:00:00' ),
			array( 'Dallas', '2018-11-28 19:00:00' ),
			array( 'Los Angeles', '2018-11-30 19:00:00' ),
			array( 'Minnesota', '2018-12-06 19:00:00' ),
			array( 'Nashville', '2018-12-08 20:00:00' ),
			array( 'Philadelphia', '2018-12-12 06:30:00' ),
			array( 'Tampa Bay', '2018-12-20 19:00:00' ),
			array( 'St. Louis', '2018-12-22 14:00:00' ),
			array( 'Vancouver', '2018-12-29 20:00:00' ),
			array( 'San Jose', '2018-12-31 19:00:00' ),
			array( 'Colorado', '2019-01-09 19:30:00' ),
			array( 'Florida', '2019-01-11 19:00:00' ),
			array( 'Arizona', '2019-01-13 19:30:00' ),
			array( 'Arizona', '2019-01-16 19:30:00' ),
			array( 'Detroit', '2019-01-18 19:00:00' ),
			array( 'Carolina', '2019-01-22 19:00:00' ),
			array( 'San Jose', '2019-02-07 19:00:00' ),
			array( 'Arizona', '2019-02-18 14:00:00' ),
			array( 'N.Y. Islanders', '2019-02-20 19:30:00' ),
			array( 'Anaheim', '2019-02-22 19:00:00' ),
			array( 'Minnesota', '2019-03-02 20:00:00' ),
			array( 'Toronto', '2019-03-04 19:00:00' ),
			array( 'Vegas', '2019-03-10 19:30:00' ),
			array( 'New Jersey', '2019-03-12 19:00:00' ),
			array( 'N.Y. Rangers', '2019-03-15 19:00:00' ),
			array( 'Columbus', '2019-03-19 19:00:00' ),
			array( 'Ottawa', '2019-03-21 19:00:00' ),
			array( 'Los Angeles', '2019-03-25 19:00:00' ),
			array( 'Dallas', '2019-03-27 19:30:00' ),
			array( 'Anaheim', '2019-03-29 19:00:00' ),
			array( 'Edmonton', '2019-04-06 20:00:00' ),
		);


		foreach ( $schedules as $schedule ) {
			DB::table( 'schedules' )->insert(
				[
					'name' => $schedule[0],
					'time' => $schedule[1],
				] );
		}


	}
}
