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
        Schema::create('vehicle_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('path'); // Storage path
            $table->string('url')->nullable(); // Full URL if stored externally
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_primary')->default(false);
            $table->string('caption')->nullable();
            $table->timestamps();

            $table->index(['vehicle_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_images');
    }
};
