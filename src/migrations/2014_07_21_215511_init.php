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
        // Creates the admins table
        Schema::create('admins', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('login');
            $table->string('password');
            $table->timestamps();
        });

        // Creates the settings table
        Schema::create('settings', function($table)
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
        Schema::drop('admins');
        Schema::drop('settings');
	}

}
