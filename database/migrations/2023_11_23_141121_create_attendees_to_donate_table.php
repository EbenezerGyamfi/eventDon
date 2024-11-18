<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendeesToDonateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees_to_donate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendee_id');
            $table->unsignedBigInteger('event_id');
            $table->string('phone');
            $table->string('ussd_session_id');
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
        Schema::dropIfExists('attendees_to_donate');
    }
}
