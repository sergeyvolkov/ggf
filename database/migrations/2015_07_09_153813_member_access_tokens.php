<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberAccessTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_tokens', function (Blueprint $table) {
            $table->increments('memberId');
            $table->string('accessToken');
            $table->string('sessionId');
            $table->timestamps();
        });

        Schema::table('member_tokens', function(Blueprint $table) {
            $table->foreign('memberId')
                ->references('id')
                ->on('members')
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
        Schema::table('member_tokens', function(Blueprint $table) {
            $table->dropForeign('member_tokens_memberid_foreign');
        });

        Schema::drop('member_tokens');
    }
}
