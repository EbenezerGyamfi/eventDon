<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnToUssdExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ussd_extensions', function (Blueprint $table) {
            $table->string('type')
                ->after('code')
                ->default('attendance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ussd_extensions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
