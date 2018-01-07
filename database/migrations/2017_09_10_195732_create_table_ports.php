<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePorts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('zone_id')->unsigned();
            $table->foreign('zone_id')->references('id')->on('zones');
            $table->decimal('max_laden_draft')->nullable();
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->decimal('draft_factor');
            $table->timestamps();
            $table->softDeletes();
        });
       // DB::statement('ALTER TABLE ports ADD location POINT' );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('ports');
    }
}
