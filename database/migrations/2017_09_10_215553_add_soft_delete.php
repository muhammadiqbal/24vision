<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ship_types', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ship_specializations', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ships', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ports', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('stowage_factor_units', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('quantity_measurements', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('loading_dischaging_rate_type', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('freight_idea_measurements', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('cargos', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('ship_positions', function (Blueprint $table) {
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
    }
}
