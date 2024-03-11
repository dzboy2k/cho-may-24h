<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->tinyInteger('type');
            $table->bigInteger('fluctuation');
            $table->timestamps(0);
            $table->tinyInteger('status');
            $table->bigInteger('wallet_id')->unsigned();
            $table->string('description');

            $table
                ->foreign('wallet_id')
                ->references('id')
                ->on('wallets');
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
};
