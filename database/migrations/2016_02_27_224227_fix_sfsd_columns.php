<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSfsdColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthlyobs', function (Blueprint $table) {
          if(Schema::hasColumn('monthlyobs', 'SF_grtr50')){
            $table->renameColumn("SF_grtr50", 'sf_grtr1');
          }
          if(Schema::hasColumn('monthlyobs', 'SF_grtr100')){
            $table->renameColumn("SF_grtr100", 'sf_grtr3');
          }
          if(Schema::hasColumn('monthlyobs', 'SF_grtr500')){
            $table->renameColumn("SF_grtr500", 'sf_grtr6');
          }
          if(Schema::hasColumn('monthlyobs', 'SF_grtr1000')){
            $table->renameColumn("SF_grtr1000", 'sf_grtr12');
          }
          if(!Schema::hasColumn('monthlyobs', 'sf_grtr18')){
            $table->integer('sf_grtr18')->default(0);
          }

          if(Schema::hasColumn('monthlyobs', 'SD_grtr50')){
            $table->renameColumn("SD_grtr50", 'sd_grtr1');
          }
          if(Schema::hasColumn('monthlyobs', 'SD_grtr100')){
            $table->renameColumn("SD_grtr100", 'sd_grtr3');
          }
          if(Schema::hasColumn('monthlyobs', 'SD_grtr500')){
            $table->renameColumn("SD_grtr500", 'sd_grtr6');
          }
          if(Schema::hasColumn('monthlyobs', 'SD_grtr1000')){
            $table->renameColumn("SD_grtr1000", 'sd_grtr12');
          }
          if(!Schema::hasColumn('monthlyobs', 'sd_grtr18')){
            $table->integer('sd_grtr18')->default(0);
          }
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
          $table->renameColumn('sf_grtr1', 'SF_grtr50');
          $table->renameColumn('sf_grtr3', 'SF_grtr100');
          $table->renameColumn('sf_grtr6', 'SF_grtr500');
          $table->renameColumn('sf_grtr12', 'SF_grtr1000');
          $table->dropColumn('sf_grtr18');

          $table->renameColumn('sd_grtr1', 'SD_grtr50');
          $table->renameColumn('sd_grtr3', 'SD_grtr100');
          $table->renameColumn('sd_grtr6', 'SD_grtr500');
          $table->renameColumn('sd_grtr12', 'SD_grtr1000');
          $table->dropColumn('sd_grtr18');
        });
    }
}
