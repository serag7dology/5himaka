<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWalletIdColumnToWalletHistoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_history_translations', function (Blueprint $table) {
            $table->bigInteger('wallet_history_id')->after('operation_type')
            ->nullable()
            ->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_history_translations', function (Blueprint $table) {

        });
    }
}
