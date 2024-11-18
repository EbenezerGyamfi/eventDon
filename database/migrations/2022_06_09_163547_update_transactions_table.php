<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            if ($driver == 'sqlite') {
                $table->string('status')
                    ->after('description')
                    ->nullable();
            } else {
                $table->string('status')
                    ->after('description');
            }
        });

        Transaction::query()->update(['status' => Transaction::$SUCCESS]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
