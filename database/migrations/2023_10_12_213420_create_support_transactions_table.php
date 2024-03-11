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
        Schema::create('support_transactions', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->bigInteger('fluctuation');
            $table->timestamps(0);
            $table->dateTime('expiration_date')->index();
            $table->bigInteger('wallet_id')->unsigned();
            $table->string('description');
            $table->boolean('is_need_for_calc_each_day');
            $table->tinyInteger('receive_type');

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
        Schema::dropIfExists('support_transactions');
    }
};
