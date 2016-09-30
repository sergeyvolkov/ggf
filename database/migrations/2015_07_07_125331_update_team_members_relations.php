<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTeamMembersRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::table('team_members', function(Blueprint $table) {
            $table->dropForeign('team_members_teamid_foreign');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->renameColumn("\"teamId\"", "\"tournamentTeamId\"");
        });

        Schema::table('team_members', function(Blueprint $table) {
            $table->foreign('tournamentTeamId', 'team_members_tournamentTeamId_foreign')
                ->references('id')
                ->on('tournament_teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_members', function(Blueprint $table) {
            $table->dropForeign('team_members_tournamentTeamId_foreign');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->renameColumn("\"tournamentTeamId\"", "\"teamId\"");
        });

        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('team_members', function(Blueprint $table) {
            $table->foreign('teamId')->references('id')->on('teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }
}
