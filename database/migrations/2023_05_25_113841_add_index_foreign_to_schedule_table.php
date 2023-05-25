<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedule', function (Blueprint $table) {
            $table->index(['id_call', 'id_group', 'id_couples', 'id_user']);
            $table->foreign('id_call')->references('id')->on('calls');
            $table->foreign('id_group')->references('id')->on('groups');
            $table->foreign('id_couples')->references('id')->on('couples');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedule', function (Blueprint $table) {
            $table->dropForeign(['id_call', 'id_group', 'id_couples', 'id_user']);
        });
    }
};
