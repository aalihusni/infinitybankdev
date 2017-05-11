<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('email_verify_code');
			$table->boolean('email_verify_status');
			$table->string('password', 60);
			$table->string('alias', 100);
			$table->boolean('alias_changed');
			$table->integer('user_type');
			$table->integer('user_class');
			$table->integer('referral_id');
			$table->integer('upline_id');
			$table->integer('tree_position');
			$table->integer('tree_slot');
			$table->integer('global_level');
			$table->integer('global_level_bank');
			$table->text('hierarchy', 65535);
			$table->text('hierarchy_bank', 65535);
			$table->integer('locked_upline_id');
			$table->dateTime('locked_upline_at')->default('0000-00-00 00:00:00');
			$table->boolean('active');
			$table->integer('chat_id');
			$table->string('firstname');
			$table->string('lastname');
			$table->string('profile_pic');
			$table->string('gender');
			$table->string('device_id', 50);
			$table->string('address');
			$table->string('city');
			$table->string('zipcode');
			$table->string('state');
			$table->string('country_code');
			$table->string('mobile', 225);
			$table->boolean('mobile_share');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
