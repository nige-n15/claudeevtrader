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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained()->onDelete('cascade');

            // Plan Details
            $table->enum('plan', ['starter', 'professional', 'enterprise'])->default('starter');
            $table->integer('vehicle_limit')->default(25); // Based on plan
            $table->decimal('monthly_price', 8, 2);

            // Subscription Status
            $table->enum('status', ['active', 'cancelled', 'expired', 'suspended'])->default('active');

            // Dates
            $table->timestamp('started_at');
            $table->timestamp('current_period_start');
            $table->timestamp('current_period_end');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            // Payment
            $table->string('stripe_subscription_id')->nullable()->unique();
            $table->string('stripe_customer_id')->nullable();
            $table->string('payment_method')->nullable(); // card, bank_transfer, etc

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
