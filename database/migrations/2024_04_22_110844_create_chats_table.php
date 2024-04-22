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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_id')->nullable();
            $table->foreign('from_id', 'from_fk_7773176')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id', 'parent_id_fk_7773178')->references('id')->on('chats')->onDelete('cascade');
            $table->string('message')->nullable();
            $table->bigInteger('timeline_id')->unsigned()->nullable();
            $table->bigInteger('outline_id')->unsigned()->nullable();
            $table->bigInteger('plot_planner_id')->unsigned()->nullable();
            $table->bigInteger('brainstorm_id')->unsigned()->nullable();
            $table->bigInteger('book_id')->unsigned()->nullable();
            $table->bigInteger('series_id')->unsigned()->nullable();
            $table->tinyInteger('is_deleted')->unsigned()->default(0);
            $table->tinyInteger('is_read')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
