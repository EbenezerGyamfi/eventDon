<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->foreignId('event_id')->nullable();
            $table->foreignId('sms_campaign_id')->nullable()->constrained();
            $table->string('sms_id')->nullable();
            $table->string('sender');
            $table->string('phone');
            $table->mediumText('message');
            $table->string('status');
            $table->decimal('cost')->default(0);
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
        Schema::dropIfExists('sms_histories');
    }
}
