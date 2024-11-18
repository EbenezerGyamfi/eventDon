<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAndUpdateFieldsInDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('user_id')->after('event_id')->nullable()->constrained('users');
            $table->dropConstrainedForeignId('entered_by');
            $table->enum('type', ['ussd', 'manual'])->after('amount');
            $table->decimal('amount', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->foreignId('entered_by')->after('event_id')->constrained('users');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('type');
            $table->decimal('amount', 8, 2)->change();
        });
    }
}
