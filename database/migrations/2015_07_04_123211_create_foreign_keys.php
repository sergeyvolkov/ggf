<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('team_members', function(Blueprint $table) {
			$table->foreign('memberId')->references('id')->on('members')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('team_members', function(Blueprint $table) {
			$table->foreign('teamId')->references('id')->on('teams')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tournament_teams', function(Blueprint $table) {
			$table->foreign('teamId')->references('id')->on('teams')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tournament_teams', function(Blueprint $table) {
			$table->foreign('tournamentId')->references('id')->on('tournaments')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('team_members', function(Blueprint $table) {
			$table->dropForeign('team_members_memberId_foreign');
		});
		Schema::table('team_members', function(Blueprint $table) {
			$table->dropForeign('team_members_teamid_foreign');
		});
		Schema::table('tournament_teams', function(Blueprint $table) {
			$table->dropForeign('tournament_teams_teamid_foreign');
		});
		Schema::table('tournament_teams', function(Blueprint $table) {
			$table->dropForeign('tournament_teams_tournamentid_foreign');
		});
	}
}
