<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCargoType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::create('cargo_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('stowage_factor')->nullable();
            $table->integer('sf_unit')->unsigned()->nullable();
            $table->foreign('sf_unit')->references('id')->on('stowage_factor_units');
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
        Schema::dropIfExists('cargo_types');
    }
}
