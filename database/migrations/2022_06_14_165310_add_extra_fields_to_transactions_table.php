<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->change();

            $table->foreignId('wallet_id')
                ->nullable()
                ->change();

            $table->json('metadata')
                ->after('status')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('user_id')->change();
            $table->foreignId('wallet_id')->change();
            $table->dropColumn('metadata');
        });
    }
}
