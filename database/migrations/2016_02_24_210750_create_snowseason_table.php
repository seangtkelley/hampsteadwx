<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnowseasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('snowseason')) {
        Schema::create('snowseason', function (Blueprint $table) {
            $table->increments('id');
            $table->string('winter');
            $table->float('oct');
            $table->float('nov');
            $table->float('dec');
            $table->float('jan');
            $table->float('feb');
            $table->float('mar');
            $table->float('apr');
            $table->float('may');
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
        Schema::drop('snowseason');
    }
}
