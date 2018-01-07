<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRoutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

         Schema::create('routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('zone1')->unsigned();
            $table->foreign('zone1')->references('id')->on('zones');
            $table->integer('zone2')->unsigned()->nullable();
            $table->foreign('zone2')->references('id')->on('zones');
            $table->integer('zone3')->unsigned();
            $table->foreign('zone3')->references('id')->on('zones');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('routes');
    }
}
