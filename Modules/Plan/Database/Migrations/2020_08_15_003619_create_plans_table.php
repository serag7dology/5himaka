<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('currency',['EG','Dollar'])->nullable();
            $table->enum('duration',[1,2,3,4])->nullable(); //daily,weekly,monthly,yearly
            $table->integer('points')->nullable();
            $table->integer('limit')->nullable();  //50000 LE or 50000 Dollar 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
