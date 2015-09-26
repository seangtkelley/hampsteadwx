<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('dailyobs')) {
        Schema::create('dailyobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->float('max');
            $table->float('min');
            $table->float('atob');
            $table->float('precip');
            $table->float('snowfall');
            $table->float('snowdepth');
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
      Schema::drop('dailyobs');
    }
}
