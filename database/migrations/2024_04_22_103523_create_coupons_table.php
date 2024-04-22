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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->unique();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('package_type')->comment("Monthly, Yearly, Both");
            $table->float('discount_amount', 15, 2);
            $table->tinyInteger('discount_type');
            $table->integer('number_of_usage')->nullable();
            $table->integer('usage_count')->default(0);
            $table->date('date_of_expiry')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
