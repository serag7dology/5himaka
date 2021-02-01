<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            //
            $table->integer('subscription_cost')->nullable(); //165 LE OR Dollar
            $table->integer('commission')->nullable();   //5 LE OR Dollar
            $table->integer('max_people')->nullable();   //5 peoples under each one (branchs)
            //we can get max_people in each branch (limit/(commission*max_people))
            $table->integer('min_commission_to_appear')->nullable(); //125 LE or Dollar
            


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            //
        });
    }
}
