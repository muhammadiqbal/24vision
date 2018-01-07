<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDistances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('distances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('start_port')->unsigned();
            $table->foreign('start_port')->references('id')->on('ports');
            $table->integer('end_port')->unsigned();
            $table->foreign('end_port')->references('id')->on('ports');
            $table->decimal('distance');
            $table->integer('path_id')->unsigned();
            $table->foreign('path_id')->references('id')->on('paths');      
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
        Schema::dropIfExists('distances');
    }
}
