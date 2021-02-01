<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('national_id')->nullable();
            $table->string('pin')->nullable();
            $table->string('mobile')->nullable();
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->integer('commission_acount')->default(0);
            $table->integer('profit_acount')->default(0);
            $table->integer('cachback_caccount')->default(0);
            $table->integer('cadeau_acount')->default(0);
            $table->integer('personal_acount')->default(0);
            $table->float('incremental_points')->default(0);
            $table->float('points')->default(0);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
