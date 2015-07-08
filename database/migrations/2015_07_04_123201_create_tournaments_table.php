<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentsTable extends Migration {

	public function up()
	{
		Schema::create('tournaments', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 128)->index();
			$table->text('description')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tournaments');
	}
}