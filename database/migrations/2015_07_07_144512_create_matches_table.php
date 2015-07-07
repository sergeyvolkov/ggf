<?php

use App\Models\Match;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    public function up()
    {
        Schema::create('matches', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('tournamentId')->unsigned();
            $table->integer('homeTournamentTeamId')->unsigned();
            $table->integer('awayTournamentTeamId')->unsigned();
            $table->tinyInteger('homeScore')->unsigned();
            $table->tinyInteger('awayScore')->unsigned();
            $table->tinyInteger('homePenaltyScore')->unsigned();
            $table->tinyInteger('awayPenaltyScore')->unsigned();
            $table->enum('gameType', Match::getAvailableGameTypes());
            $table->enum('resultType', Match::getAvailableResultTypes());
            $table->enum('status', Match::getAvailableStatuses())->default(Match::STATUS_NOT_STARTED);
            $table->timestamps();
        });

        Schema::table('matches', function(Blueprint $table) {
            $table->foreign('homeTournamentTeamId')->references('id')->on('tournament_teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('awayTournamentTeamId')->references('id')->on('tournament_teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::drop('matches');
    }
}
