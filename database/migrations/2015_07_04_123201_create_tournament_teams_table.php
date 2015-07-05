<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTournamentTeamsTable extends Migration {

	public function up()
	{
		Schema::create('tournament_teams', function(Blueprint $table) {
			$table->integer('teamId')->unsigned();
			$table->integer('tournamentId')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('tournament_teams');
	}
}