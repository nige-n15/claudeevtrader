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
        Schema::create('dealers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trading_name')->nullable();
            $table->string('company_number')->nullable()->unique();
            $table->string('vat_number')->nullable();

            // Contact Information
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('website')->nullable();

            // Address
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('county')->nullable();
            $table->string('postcode');
            $table->string('country')->default('GB');

            // Business Details
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();

            // Settings
            $table->json('contact_preferences')->nullable(); // How they want to receive leads
            $table->json('opening_hours')->nullable();
            $table->boolean('display_phone')->default(true);
            $table->boolean('display_email')->default(true);
            $table->boolean('allow_reservations')->default(true);

            // Status
            $table->enum('status', ['active', 'suspended', 'cancelled'])->default('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dealers');
    }
};
