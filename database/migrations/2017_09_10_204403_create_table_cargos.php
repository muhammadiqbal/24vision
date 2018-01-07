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
            $table->increments('id');
            $table->string('customer')->nullable();
            $table->integer('loading_port')->unsigned()->nullable();
            $table->foreign('loading_port')->references('id')->on('ports');
            $table->integer('discharging_port')->unsigned();
            $table->foreign('discharging_port')->references('id')->on('ports');
            $table->date('laycan_first_day')->nullable();
            $table->date('laycan_last_day')->nullable();
            $table->integer('cargo_type_id')->unsigned()->nullable();
            $table->foreign('cargo_type_id')->references('id')->on('cargo_types');
            $table->integer('stowage_factor')->nullable();
            $table->integer('sf_unit')->unsigned()->nullable();
            $table->foreign('sf_unit')->references('id')->on('stowage_factor_units');
            $table->integer('ship_specialization_id')->unsigned()->nullable();
            $table->foreign('ship_specialization_id')->references('id')->on('ship_specializations');
            $table->integer('quantity_measurement_id')->unsigned()->nullable();
            $table->foreign('quantity_measurement_id')->references('id')->on('quantity_measurements');
            $table->integer('quantity')->nullable();
            $table->integer('loading_rate_type')->unsigned()->nullable();
            $table->foreign('loading_rate_type')->references('id')->on('loading_discharging_rate_type');
            $table->integer('loading_rate')->nullable();
            $table->integer('discharging_rate_type')->unsigned()->nullable();
            $table->foreign('discharging_rate_type')->references('id')->on('loading_discharging_rate_type');
            $table->integer('discharging_rate')->nullable();
            $table->text('extra_condition')->nullable();
            $table->decimal('comission')->nullable();
            $table->integer('email_id')->unsigned();
            //$table->foreign('email_id')->references('id')->on('email');
             $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('cargo_status');
            $table->timestamps();
            $table->softDeletes();
        });
        // DB::statement('ALTER table cargo.cargos ADD FOREIGN KEY (email_id) REFERENCES dbpsbulkcargo.email(emailID)');
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
