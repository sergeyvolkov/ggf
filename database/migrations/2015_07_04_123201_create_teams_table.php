<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsTable extends Migration {

	public function up()
	{
		Schema::create('teams', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 128);
			$table->string('logoPath', 256);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('teams');
	}
}