<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexForTournamentTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
           $table->unique(['teamId', 'tournamentId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_teams', function (Blueprint $table) {
            $table->dropUnique('tournament_teams_teamid_tournamentid_unique');
        });
    }
}
