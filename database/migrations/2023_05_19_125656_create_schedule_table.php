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
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->nullable();
            $table->bigInteger('id_call')->nullable()->unsigned();
            $table->bigInteger('id_group')->nullable()->unsigned();
            $table->bigInteger('id_couples')->nullable()->unsigned();
            $table->bigInteger('id_user')->nullable()->unsigned();
            $table->string('office')->nullable();
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
        Schema::dropIfExists('schedule');
    }
};
