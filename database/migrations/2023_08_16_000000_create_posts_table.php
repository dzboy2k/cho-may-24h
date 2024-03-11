<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('brand_id');
            $table->tinyInteger('is_partner')->default(0);
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->string('title');
            $table->text('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->text('addition_info');
            $table->boolean('is_official');
            $table->double('price');
            $table->double('support_limit');
            $table->double('receive_support');
            $table->tinyInteger('expire_limit_month');
            $table->text('description');
            $table->text('address')->nullable();
            $table->integer('amount_view');
            $table->tinyInteger('post_state');
            $table->string('slug')->unique();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->dateTime('release_date')->nullable();
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
};
