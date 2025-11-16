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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained()->onDelete('cascade');

            // Basic Vehicle Info
            $table->string('vin')->nullable()->unique();
            $table->string('registration')->nullable();
            $table->string('make');
            $table->string('model');
            $table->string('variant')->nullable();
            $table->integer('year');
            $table->integer('mileage');
            $table->enum('mileage_unit', ['miles', 'kilometers'])->default('miles');

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable(); // For showing discounts
            $table->boolean('price_negotiable')->default(false);
            $table->string('price_notes')->nullable(); // e.g., "Plus VAT"

            // Technical Details
            $table->string('body_type')->nullable(); // Hatchback, Sedan, SUV, etc
            $table->string('fuel_type')->nullable(); // Petrol, Diesel, Electric, Hybrid
            $table->string('transmission')->nullable(); // Manual, Automatic
            $table->string('engine_size')->nullable(); // e.g., "2.0L"
            $table->integer('engine_power')->nullable(); // BHP
            $table->integer('doors')->nullable();
            $table->integer('seats')->nullable();
            $table->string('drivetrain')->nullable(); // FWD, RWD, AWD
            $table->string('exterior_color')->nullable();
            $table->string('interior_color')->nullable();

            // Condition & History
            $table->enum('condition', ['new', 'used', 'certified_pre_owned'])->default('used');
            $table->integer('previous_owners')->nullable();
            $table->string('service_history')->nullable(); // Full, Partial, None
            $table->boolean('hpi_clear')->default(true);
            $table->date('mot_expiry')->nullable();
            $table->date('tax_expiry')->nullable();
            $table->decimal('road_tax_annual', 8, 2)->nullable();

            // Features (stored as JSON for flexibility)
            $table->json('features')->nullable(); // Safety, Comfort, Entertainment features

            // Description & Marketing
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();

            // Status
            $table->enum('status', ['available', 'reserved', 'sold', 'pending', 'hidden'])->default('available');
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('sold_at')->nullable();

            // SEO & Discovery
            $table->boolean('featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('leads_count')->default(0);

            // Import tracking
            $table->foreignId('import_job_id')->nullable()->constrained()->nullOnDelete();
            $table->string('external_id')->nullable(); // ID from DMS

            $table->timestamps();
            $table->softDeletes();

            // Indexes for search performance
            $table->index(['dealer_id', 'status']);
            $table->index(['make', 'model']);
            $table->index('price');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
