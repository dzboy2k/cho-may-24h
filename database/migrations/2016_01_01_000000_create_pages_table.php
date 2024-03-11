<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use TCG\Voyager\Models\Page;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->boolean('is_service')->default(false);
            $table->boolean('show_in_home_slide')->default(false);
            $table->boolean('show_in_header')->default(false);
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->text('meta_description')->nullable();
            $table
                ->enum('status', Page::$statuses)
                ->default(Page::STATUS_INACTIVE);
            $table->timestamps();
            $table
                ->foreign('author_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
