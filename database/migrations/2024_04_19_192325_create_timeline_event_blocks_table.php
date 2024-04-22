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
        Schema::create('timeline_event_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('series_id')->nullable();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->unsignedBigInteger('timeline_id')->nullable();
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->unsignedBigInteger('outline_id')->nullable();
            $table->unsignedBigInteger('timeline_character_id')->nullable();
            $table->string('event_name');
            $table->string('event_description')->nullable();
            $table->float('position_x', 15, 2);
            $table->float('size', 15, 2);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('timeline_event_types')->onDelete('cascade');
            $table->foreign('outline_id')->references('id')->on('outlines')->onDelete('cascade');
            $table->foreign('timeline_character_id')->references('id')->on('timeline_characters')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_event_blocks');
    }
};
