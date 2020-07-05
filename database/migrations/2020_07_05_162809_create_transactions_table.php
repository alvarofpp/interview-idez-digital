<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->float('value');

            $table->string('transaction_type_id', 5);
            $table->foreign('transaction_type_id')
                ->references('id')
                ->on('transaction_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->integer('account_from_id')
                ->unsigned();
            $table->foreign('account_from_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('SET NULL')
                ->onDelete('SET NULL');

            $table->integer('account_to_id')
                ->unsigned();
            $table->foreign('account_to_id')
                ->references('id')
                ->on('accounts')
                ->onUpdate('SET NULL')
                ->onDelete('SET NULL');

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
        Schema::dropIfExists('transactions');
    }
}
