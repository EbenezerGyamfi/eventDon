<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('event_id');
            $table->enum('type', ['wrapped parcel', 'unwrapped parcel']);
            $table->string('code');
            $table->string('name')->nullable();
            $table->double('quantity')->default(1);
            $table->text('description')->nullable();
            $table->integer('attendee_id')->nullable();
            $table->integer('received_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
