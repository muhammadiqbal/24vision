<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCargos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cargos', function (Blueprint $table) {
            $table->integer('loading_port')->unsigned();
            $table->foreign('loading_port')->references('id')->on('ports');
            $table->integer('discharging_port')->unsigned();
            $table->foreign('discharging_port')->references('id')->on('ports');
            $table->date('laycan_first_day');
            $table->date('laycan_last_day');
            $table->string('cargo_description');
            $table->integer('stowage_factor');
            $table->integer('sf_unit')->unsigned();
            $table->foreign('sf_unit')->references('id')->on('stowage_factor_units');
            $table->integer('ship_specialization_id')->unsigned();
            $table->foreign('ship_specialization_id')->references('id')->on('ship_specializations');
            $table->integer('quantity_measurement_id')->unsigned();
            $table->foreign('quantity_measurement_id')->references('id')->on('quantity_measurements');
            $table->integer('quantity');
            $table->integer('loading_rate_type')->unsigned();
            $table->foreign('loading_rate_type')->references('id')->on('loading_dischaging_rate_type');
            $table->integer('loading_rate');
            $table->integer('discharging_rate_type')->unsigned();
            $table->foreign('discharging_rate_type')->references('id')->on('loading_dischaging_rate_type');
            $table->integer('discharging_rate');
            $table->integer('freight_idea_measurement_id')->unsigned();
            $table->foreign('freight_idea_measurement_id')->references('id')->on('freight_idea_measurements');
            $table->integer('freight_idea');
            $table->text('extra_condition');
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
        Schema::dropIfExists('cargos');
    }
}
