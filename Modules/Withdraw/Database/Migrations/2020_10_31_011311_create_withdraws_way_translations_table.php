<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawsWayTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws_way_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('withdraws_way_id')->unsigned();
            $table->string('locale');
            $table->string('name');
            $table->string('field_name');
            $table->unique(['withdraws_way_id', 'locale']);
            $table->foreign('withdraws_way_id')->references('id')->on('withdraws_ways')->onDelete('cascade');

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
        Schema::dropIfExists('withdraws_way_translations');
    }
}
