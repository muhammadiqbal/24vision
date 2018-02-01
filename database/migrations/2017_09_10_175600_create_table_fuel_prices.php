<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFuelPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fuel_prices', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('fuel_type_id')->unsigned();
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types');
            $table->decimal('price');
            $table->date('start_date');
            $table->date('end_date')->nullable();
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
         Schema::dropIfExists('fuel_prices');
    }
}
