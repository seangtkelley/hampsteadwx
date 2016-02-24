<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSFSDColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthlyobs', function (Blueprint $table) {
          $table->integer('SF_grtr50')->default(0);
          $table->integer('SF_grtr100')->default(0);
          $table->integer('SF_grtr500')->default(0);
          $table->integer('SF_grtr1000')->default(0);
          $table->integer('SD_grtr50')->default(0);
          $table->integer('SD_grtr100')->default(0);
          $table->integer('SD_grtr500')->default(0);
          $table->integer('SD_grtr1000')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthlyobs', function (Blueprint $table) {
          $table->dropColumn('SF_grtr50');
          $table->dropColumn('SF_grtr100');
          $table->dropColumn('SF_grtr500');
          $table->dropColumn('SF_grtr1000');
          $table->dropColumn('SD_grtr50');
          $table->dropColumn('SD_grtr100');
          $table->dropColumn('SD_grtr500');
          $table->dropColumn('SD_grtr1000');
        });
    }
}
