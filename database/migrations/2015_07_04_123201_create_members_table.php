<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMembersTable extends Migration {

	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 128)->index();
			$table->string('facebookId', 128)->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('members');
	}
}