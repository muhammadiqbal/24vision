<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipPositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ship_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ship_id')->unsigned();
            $table->foreign('ship_id')->references('id')->on('ships');
            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')->on('regions');
            $table->integer('port_id')->unsigned();
            $table->foreign('port_id')->references('id')->on('ports');
            $table->date('date_of_opening');
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
        //
        Schema::dropIfExists('ship_positions');
    }
}
