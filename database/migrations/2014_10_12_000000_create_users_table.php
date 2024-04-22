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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('email',255)->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password',255);
            $table->dateTime('password_last_changed')->nullable();
            $table->string('password_reset_code',50)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('subscription_id')->nullable();
            $table->string('subscription_type', 30)->nullable();
            $table->dateTime('subscription_date')->nullable();
            $table->tinyInteger('user_type')->default(0);
            $table->dateTime('subscription_expiration_date')->nullable();
            $table->tinyInteger('subscribed_with_free_coupon')->default(0);
            $table->dateTime('last_seen')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
