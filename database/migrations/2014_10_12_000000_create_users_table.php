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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->unique();
            $table->smallInteger('gender')->nullable();
            $table->date('dob')->nullable();
            $table->text('introduce')->nullable();
            $table->string('avatar')->default(config('constants.DEFAULT_AVT_PATH'));
            $table->string('api_auth_token')->unique()->nullable();
            $table->string('referral_code',config('constants.USER_REFERRAL_CODE_LENGTH'))->unique();
            $table->string('reset_code')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('api_auth_token');
            $table->index('referral_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
