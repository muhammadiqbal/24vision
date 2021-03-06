<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('imo')->unique()->nullable();
            $table->date('year_of_build')->nullable();
            $table->integer('dwcc');
            $table->decimal('max_holds_capacity');
            $table->decimal('ballast_draft');
            $table->decimal('max_laden_draft');
            $table->decimal('draft_per_tonnage');
            $table->decimal('speed_laden');
            $table->decimal('speed_ballast');
            $table->integer('fuel_type_id')->unsigned();
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types');
            $table->decimal('fuel_consumption_at_sea')->nullable();
            $table->decimal('fuel_consumption_in_port')->nullable();
            $table->string('flag');
            $table->integer('ship_type_id')->unsigned();
            $table->foreign('ship_type_id')->references('id')->on('ship_types');
            $table->integer('ship_specialization_id')->unsigned();
            $table->foreign('ship_specialization_id')->references('id')->on('ship_specializations');
            $table->text('gear_onboard')->nullable();
            $table->text('additional_information')->nullable();
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
        Schema::dropIfExists('ships');
    }
}
