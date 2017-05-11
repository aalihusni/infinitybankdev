<?php

use Illuminate\Database\Seeder;

class PasswordResetsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('password_resets')->delete();
        
		\DB::table('password_resets')->insert(array (
			0 => 
			array (
				'email' => 'a@a.com',
				'token' => '111',
				'created_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
