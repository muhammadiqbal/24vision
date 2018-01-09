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

            $table->integer('loading_port')->unsigned()->nullable();
            $table->foreign('loading_port')->references('id')->on('ports');
            $table->boolean('loading_port_manual')->default(false)->nullable();
            
            $table->integer('discharging_port')->unsigned()->nullable();
            $table->foreign('discharging_port')->references('id')->on('ports');
            $table->boolean('discharging_port_manual')->default(false)->nullable();
            
            $table->date('laycan_first_day')->nullable();
            $table->boolean('laycan_first_day_manual')->default(false)->nullable();
            $table->boolean('laycan_first_day_constructed')->default(false)->nullable();
            
            $table->date('laycan_last_day')->nullable();
            $table->boolean('laycan_last_day_manual')->default(false)->nullable();
            $table->boolean('laycan_last_day_constructed')->default(false)->nullable();
            
            $table->integer('cargo_type_id')->unsigned()->nullable();
            $table->foreign('cargo_type_id')->references('id')->on('cargo_types');
            $table->boolean('cargo_type_id_manual')->default(false)->nullable();
            
            $table->decimal('stowage_factor')->nullable();
            $table->boolean('stowage_factor_manual')->default(false)->nullable();
            $table->boolean('stowage_factor_constructed')->default(false)->nullable();
            
            $table->integer('sf_unit')->unsigned()->nullable();
            $table->foreign('sf_unit')->references('id')->on('stowage_factor_units');
            
            $table->integer('ship_specialization_id')->unsigned()->nullable();
            $table->foreign('ship_specialization_id')->references('id')->on('ship_specializations');
            
            $table->integer('quantity_measurement_id')->unsigned()->nullable();
            $table->foreign('quantity_measurement_id')->references('id')->on('quantity_measurements');
            
            $table->integer('quantity')->nullable();
            $table->boolean('quantity_manual')->default(false)->nullable();
            $table->boolean('quantity_constructed')->default(false)->nullable();
            
            $table->integer('loading_rate_type')->unsigned()->nullable();
            $table->foreign('loading_rate_type')->references('id')->on('loading_discharging_rate_type');
            $table->boolean('loading_rate_type_manual')->default(false)->nullable();
            
            $table->integer('loading_rate')->nullable();
            $table->boolean('loading_rate_manual')->default(false)->nullable();
            $table->boolean('loading_rate_constructed')->default(false)->nullable();
            
            $table->integer('discharging_rate_type')->unsigned()->nullable();
            $table->foreign('discharging_rate_type')->references('id')->on('loading_discharging_rate_type');
            $table->boolean('discharging_rate_type_manual')->default(false)->nullable();
            
            $table->integer('discharging_rate')->nullable();
            $table->boolean('discharging_rate_manual')->default(false)->nullable();
            $table->boolean('discharging_rate_constructed')->default(false)->nullable();
            
            $table->text('extra_condition')->nullable();
            
            $table->decimal('commission')->nullable();
            $table->boolean('commision_manual')->default(false)->nullable();
            $table->boolean('commision_constructed')->default(false)->nullable();
            
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
