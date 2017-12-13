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
            $table->string('code');
            $table->string('name');
            $table->integer('area1')->unsigned();
            $table->foreign('area1')->references('id')->on('regions');
            $table->integer('area2')->unsigned()->nullable();
            $table->foreign('area2')->references('id')->on('regions');
            $table->integer('area3')->unsigned();
            $table->foreign('area3')->references('id')->on('regions');
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
