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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email'); // admin, dealer, customer
            $table->foreignId('dealer_id')->nullable()->after('role')->constrained()->nullOnDelete();
            $table->foreignId('current_dealer_id')->nullable()->after('dealer_id')->constrained('dealers')->nullOnDelete(); // For admin switching
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dealer_id']);
            $table->dropForeign(['current_dealer_id']);
            $table->dropColumn(['role', 'dealer_id', 'current_dealer_id']);
        });
    }
};
