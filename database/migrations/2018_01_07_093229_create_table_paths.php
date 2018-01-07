<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePaths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('paths', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('route_id')->unsigned();
            $table->foreign('route_id')->references('id')->on('routes');
            $table->integer('zone1')->unsigned();
            $table->foreign('zone1')->references('id')->on('zones');
            $table->integer('zone2')->unsigned();
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
        Schema::dropIfExists('paths');
    }
}
