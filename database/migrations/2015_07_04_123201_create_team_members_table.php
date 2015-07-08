<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamMembersTable extends Migration {

	public function up()
	{
		Schema::create('team_members', function(Blueprint $table) {
			$table->integer('memberId')->unsigned();
			$table->integer('teamId')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('team_members');
	}
}