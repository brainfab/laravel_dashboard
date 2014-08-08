<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Creates the st_admins table
        Schema::create('st_admins', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('login');
            $table->string('password');
            $table->timestamps();
        });

        //default admin
        DB::table('st_admins')->insert(array('login' => 'admin', 'password' => '21232f297a57a5a743894a0e4a801fc3'));

        // Creates the st_settings table
        Schema::create('st_settings', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->string('fax');
            $table->string('phone');
            $table->text('robots');
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
        Schema::drop('st_admins');
        Schema::drop('st_settings');
	}

}
