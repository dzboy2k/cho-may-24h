<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_withdraw_transactions', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->bigInteger('fluctuation');
            $table->timestamps(0);
            $table->string('bank_name');
            $table->string('bank_account');
            $table->string('bank_owner');
            $table->string('bank_branch');
            $table->tinyInteger('status');
            $table->string('description');
            $table->bigInteger('user_id')->unsigned();
            $table->string('base_transaction_id', 20);

            $table->foreign('user_id')->references('id')->on('users');
            $table
                ->foreign('base_transaction_id',20)
                ->references('id')
                ->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_withdraw_transactions');
    }
};
