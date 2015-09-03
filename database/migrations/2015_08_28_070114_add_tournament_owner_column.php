<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTournamentOwnerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {

            /**
             * @var $firstMember \App\Models\Member
             */
            $firstMember = DB::table('members')->first();

            if ($firstMember) {
                $table->integer('owner')->unsigned()->default($firstMember->id);
            } else {
                $table->integer('owner')->unsigned();
            }

            $table->foreign('owner', 'tournamentOwner_foreign')->references('id')->on('members')
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
        Schema::table('tournaments', function (Blueprint $table) {
            Schema::table('tournaments', function (Blueprint $table) {
                $table->dropForeign('tournamentOwner_foreign');
            });

            $table->dropColumn('owner');
        });
    }
}
