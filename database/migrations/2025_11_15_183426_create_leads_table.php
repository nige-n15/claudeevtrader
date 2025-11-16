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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('dealer_id')->constrained()->onDelete('cascade');

            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_postcode')->nullable();

            // Lead Details
            $table->enum('type', ['inquiry', 'test_drive', 'reservation', 'phone_call', 'email'])->default('inquiry');
            $table->text('message')->nullable();
            $table->enum('contact_preference', ['phone', 'email', 'either'])->default('either');
            $table->enum('contact_time', ['morning', 'afternoon', 'evening', 'anytime'])->default('anytime');

            // Part Exchange
            $table->boolean('has_part_exchange')->default(false);
            $table->json('part_exchange_details')->nullable(); // Make, model, year, mileage

            // Finance Interest
            $table->boolean('finance_interested')->default(false);
            $table->decimal('finance_deposit', 10, 2)->nullable();
            $table->integer('finance_term_months')->nullable();

            // Lead Management
            $table->enum('status', ['new', 'contacted', 'qualified', 'test_drive_booked', 'negotiating', 'won', 'lost'])->default('new');
            $table->enum('source', ['platform', 'direct', 'phone', 'email', 'other'])->default('platform');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // Dealer staff member
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->timestamp('won_at')->nullable();
            $table->timestamp('lost_at')->nullable();
            $table->string('lost_reason')->nullable();

            // Tracking
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['dealer_id', 'status']);
            $table->index(['vehicle_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
