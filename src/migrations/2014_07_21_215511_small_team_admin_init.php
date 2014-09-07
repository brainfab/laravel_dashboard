<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmallTeamAdminInit extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Creates st_admins table
        Schema::create('st_admins', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->timestamps();
        });

        //default admin
        DB::table('st_admins')->insert(array('login' => 'admin', 'password' => '21232f297a57a5a743894a0e4a801fc3'));

        // Creates st_settings table
        Schema::create('st_settings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
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
        Schema::dropIfExists('st_admins');
        Schema::dropIfExists('st_settings');
	}

}
