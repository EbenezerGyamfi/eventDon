<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAttendeeIdFieldNullableInDonationTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donation_transactions', function (Blueprint $table) {
            $table->foreignId('attendee_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donation_transactions', function (Blueprint $table) {
            $table->foreignId('attendee_id')->nullable(false)->change();
        });
    }
}
