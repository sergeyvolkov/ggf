<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Tournament;

class TournamentSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->enum('type', Tournament::getAvailableTypes())->default(Tournament::TYPE_LEAGUE);
            $table->enum('membersType', Tournament::getAvailableMembersType())->default(Tournament::MEMBERS_TYPE_SINGLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('membersType');
        });
    }
}
