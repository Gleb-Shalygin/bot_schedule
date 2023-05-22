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
        Schema::create('schedule_couples', function (Blueprint $table) {
            $table->id();
            $table->integer('id_schedule');
            $table->integer('id_couples');
            $table->integer('id_user')->nullable();
            $table->string('office')->nullable();
            $table->integer('id_call')->nullable();
            $table->integer('pair')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_couples');
    }
};
