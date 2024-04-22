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
        Schema::create('brainstorm_rounds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('transcript')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('series_id')->nullable();
            $table->foreign('series_id')->references('id')->on('series')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('book_id')->nullable();
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('brainstorm_id')->nullable();
            $table->foreign('brainstorm_id')->references('id')->on('brainstorms')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brainstorm_rounds');
    }
};
