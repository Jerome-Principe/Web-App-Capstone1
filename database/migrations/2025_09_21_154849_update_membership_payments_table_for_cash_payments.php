<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('membership_payments', function (Blueprint $table) {
            // Add payment_method column to distinguish between Cash and GCash
            $table->string('payment_method')->default('GCash')->after('membership_id');

            // Make GCash-specific fields nullable to support cash payments
            $table->string('gcash_number')->nullable()->change();
            $table->string('account_name')->nullable()->change();
            $table->string('reference_number')->nullable()->change();
            $table->string('proof_of_payment_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_payments', function (Blueprint $table) {
            // Remove payment_method column
            $table->dropColumn('payment_method');

            // Revert fields back to not nullable
            $table->string('gcash_number')->nullable(false)->change();
            $table->string('account_name')->nullable(false)->change();
            $table->string('reference_number')->nullable(false)->change();
            $table->string('proof_of_payment_url')->nullable(false)->change();
        });
    }
};
