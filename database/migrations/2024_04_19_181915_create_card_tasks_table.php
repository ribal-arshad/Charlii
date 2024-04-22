<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('series_id')->nullable();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('outline_id')->nullable();
            $table->unsignedBigInteger('chapter_id')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->unsignedBigInteger('brainstorm_item_id')->nullable();
            $table->unsignedBigInteger('outline_item_id')->nullable();
            $table->unsignedBigInteger('timeline_item_id')->nullable();
            $table->unsignedBigInteger('plot_planner_item_id')->nullable();
            $table->string('task_type')->nullable();
            $table->string('todo_item')->nullable();
            $table->date('todo_date')->nullable();
            $table->time('todo_time')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('outline_id')->references('id')->on('outlines')->onDelete('cascade');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('chapter_cards')->onDelete('cascade');
            $table->foreign('brainstorm_item_id')->references('id')->on('brainstorms')->onDelete('cascade');
            $table->foreign('outline_item_id')->references('id')->on('outlines')->onDelete('cascade');
            $table->foreign('timeline_item_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('plot_planner_item_id')->references('id')->on('plot_planners')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_tasks');
    }
};
