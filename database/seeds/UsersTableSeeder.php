<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('users')->delete();
        
		\DB::table('users')->insert(array (
			0 => 
			array (
				'id' => 1,
				'email' => 'admin@bitregion.com',
				'email_verify_code' => 'b700189f683dddfe34989c9f3d933834',
				'email_verify_status' => 1,
				'password' => '$2y$10$usKil5I8Koo9nwqeS4BaBOZQjiyZ5hEbz6pHSFQ/yOPD/icckccha',
				'alias' => 'admin',
				'alias_changed' => 1,
				'user_type' => 1,
				'user_class' => 0,
				'referral_id' => 0,
				'upline_id' => 0,
				'tree_position' => 0,
				'tree_slot' => 0,
				'global_level' => 0,
				'global_level_bank' => 0,
				'hierarchy' => '',
				'hierarchy_bank' => '',
				'locked_upline_id' => 0,
				'locked_upline_at' => '2015-10-23 23:53:17',
				'active' => 0,
				'chat_id' => 0,
				'firstname' => 'Admin',
				'lastname' => 'Admin',
				'profile_pic' => '',
				'gender' => '',
				'device_id' => '',
				'address' => '',
				'city' => '',
				'zipcode' => '',
				'state' => '',
				'country_code' => '',
				'remember_token' => 'yXCbet7Q4WzByrgKe2rJDjmsbsReQhEpVmsu2XmXTcfuijyJLyYgyhyUZcDn',
				'created_at' => '2015-10-23 12:49:03',
				'updated_at' => '2015-10-23 12:49:03',
			),
			1 => 
			array (
				'id' => 4,
				'email' => 'user@bitregion.com',
				'email_verify_code' => 'b700189f683dddfe34989c9f3d933834',
				'email_verify_status' => 1,
				'password' => '$2y$10$usKil5I8Koo9nwqeS4BaBOZQjiyZ5hEbz6pHSFQ/yOPD/icckccha',
				'alias' => 'user',
				'alias_changed' => 1,
				'user_type' => 2,
				'user_class' => 0,
				'referral_id' => 0,
				'upline_id' => 0,
				'tree_position' => 0,
				'tree_slot' => 0,
				'global_level' => 0,
				'global_level_bank' => 0,
				'hierarchy' => '',
				'hierarchy_bank' => '',
				'locked_upline_id' => 0,
				'locked_upline_at' => '2015-10-23 23:53:17',
				'active' => 0,
				'chat_id' => 0,
				'firstname' => 'User',
				'lastname' => 'User',
				'profile_pic' => '',
				'gender' => '',
				'device_id' => '',
				'address' => '',
				'city' => '',
				'zipcode' => '',
				'state' => '',
				'country_code' => '',
				'remember_token' => 'yXCbet7Q4WzByrgKe2rJDjmsbsReQhEpVmsu2XmXTcfuijyJLyYgyhyUZcDn',
				'created_at' => '2015-10-23 12:49:03',
				'updated_at' => '2015-10-23 12:49:03',
			),
			2 => 
			array (
				'id' => 5,
				'email' => 'gameble@gmail.com',
				'email_verify_code' => 'b700189f683dddfe34989c9f3d933834',
				'email_verify_status' => 1,
				'password' => '$2y$10$usKil5I8Koo9nwqeS4BaBOZQjiyZ5hEbz6pHSFQ/yOPD/icckccha',
				'alias' => 'tqvunysf',
				'alias_changed' => 0,
				'user_type' => 3,
				'user_class' => 0,
				'referral_id' => 0,
				'upline_id' => 0,
				'tree_position' => 0,
				'tree_slot' => 0,
				'global_level' => 0,
				'global_level_bank' => 0,
				'hierarchy' => '',
				'hierarchy_bank' => '',
				'locked_upline_id' => 0,
				'locked_upline_at' => '2015-10-23 23:53:17',
				'active' => 0,
				'chat_id' => 0,
				'firstname' => 'Gameble',
				'lastname' => 'Gameble',
				'profile_pic' => '',
				'gender' => '',
				'device_id' => '',
				'address' => '',
				'city' => '',
				'zipcode' => '',
				'state' => '',
				'country_code' => '',
				'remember_token' => 'yXCbet7Q4WzByrgKe2rJDjmsbsReQhEpVmsu2XmXTcfuijyJLyYgyhyUZcDn',
				'created_at' => '2015-10-23 12:49:03',
				'updated_at' => '2015-10-23 12:49:06',
			),
		));
	}

}
