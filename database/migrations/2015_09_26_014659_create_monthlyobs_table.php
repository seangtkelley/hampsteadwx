<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlyobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('monthlyobs')) {
        Schema::create('monthlyobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('month');
            $table->integer('year');
            $table->float('max_avg');
            $table->float('min_avg');
            $table->float('avg');
            $table->float('depart_temp_avg');
            $table->float('highest');
            $table->string('highest_dates');
            $table->float('lowest');
            $table->string('lowest_dates');
            $table->integer('hdd_count');
            $table->integer('cdd_count');
            $table->integer('max_over90');
            $table->integer('max_below32');
            $table->integer('min_below32');
            $table->integer('min_below0');
            $table->float('total_precip');
            $table->float('total_sf');
            $table->float('grts_precip');
            $table->string('grts_precip_dates');
            $table->float('grts_sf');
            $table->string('grts_sf_dates');
            $table->float('grts_sd');
            $table->string('grts_sd_dates');
            $table->integer('grtr01');
            $table->integer('grtr10');
            $table->integer('grtr50');
            $table->integer('grtr100');
            $table->integer('precip_grtrtrace');
            $table->integer('sf_grtrtrace');
            $table->integer('sd_grtrtrace');
            $table->string('remarks');
            $table->string('csv_file');
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
      Schema::drop('monthlyobs');
    }
}
