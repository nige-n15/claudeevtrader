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
        Schema::create('import_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dealer_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Who initiated

            // File Details
            $table->string('filename');
            $table->string('file_path');
            $table->enum('file_type', ['csv', 'xml', 'json'])->default('csv');
            $table->integer('file_size'); // In bytes

            // Processing Status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->integer('total_rows')->default(0);
            $table->integer('processed_rows')->default(0);
            $table->integer('successful_rows')->default(0);
            $table->integer('failed_rows')->default(0);

            // Results
            $table->json('errors')->nullable(); // Array of error messages
            $table->json('warnings')->nullable(); // Array of warnings
            $table->json('summary')->nullable(); // Summary stats
            $table->text('log')->nullable(); // Detailed log

            // Timing
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration_seconds')->nullable(); // Calculated duration

            $table->timestamps();

            $table->index(['dealer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_jobs');
    }
};
