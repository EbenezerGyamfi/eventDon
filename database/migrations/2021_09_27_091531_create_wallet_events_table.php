<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id');
            $table->string('description');
            $table->decimal('before_balance');
            $table->decimal('transaction_amount');
            $table->string('type');
            $table->decimal('after_balance');
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
        Schema::dropIfExists('wallet_events');
    }
}
