<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('attendee_id')->constrained('attendees');
            $table->string('msisdn');
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('amount_after_charges', 10, 2);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'failed', 'success'])->default('pending');
            $table->text('status_message')->nullable();
            $table->string('reference_id');
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
        Schema::dropIfExists('donation_transactions');
    }
}
