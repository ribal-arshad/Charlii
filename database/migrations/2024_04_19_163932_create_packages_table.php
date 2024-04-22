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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->text('package_name');
            $table->text('description')->nullable();
            $table->string('paypal_product_id')->nullable();
            $table->string('paypal_monthly_plan_id')->nullable();
            $table->string('paypal_yearly_plan_id')->nullable();
            $table->float('price_monthly', 15, 2);
            $table->float('yearly_discount', 4, 2)->nullable();
            $table->float('price_yearly', 15, 2);
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
