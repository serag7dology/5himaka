<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('wallet_id')->nullable();
            $table->string('wallet_type')->nullable();
            $table->string('current_total')->nullable();
            $table->string('pervious_total')->nullable();
            $table->string('amount_spent')->nullable();
            $table->string('wallet_type_from')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('user_id_from')->nullable();
            $table->bigInteger('user_id_to')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('wallet_history');
    }
}
