<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCargosSetNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cargos', function (Blueprint $table) {
            $table->date('laycan_last_day')->nullable();
            $table->integer('freight_idea_measurement_id')->unsigned()->nullable();
            $table->integer('freight_idea')->nullable();
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
