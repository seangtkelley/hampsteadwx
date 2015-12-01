<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSunsetLakeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('sunsetlake')) {
        Schema::create('sunsetlake', function (Blueprint $table) {
            $table->increments('id');
            $table->string('season');
            $table->string('icein');
            $table->string('iceout');
            $table->integer('duration');
            $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('sunsetlake');
    }
}
