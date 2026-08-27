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
        Schema::create('membership_renewals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id'); // Reference to existing membership
            $table->string('name'); // Member name
            $table->string('membership_type'); // Gold, Silver, Bronze
            $table->string('payment_method'); // Cash or GCash
            $table->string('gcash_number')->nullable(); // GCash number (null for Cash)
            $table->string('account_name')->nullable(); // Account name (null for Cash)
            $table->string('reference_number')->nullable(); // Reference number (null for Cash)
            $table->string('proof_of_payment_url')->nullable(); // Proof of payment file path (null for Cash)
            $table->string('status')->default('Pending'); // Pending, Approved, Declined
            $table->decimal('amount', 10, 2); // Payment amount
            $table->date('renewal_date'); // Date of renewal request
            $table->date('new_expiry_date')->nullable(); // New expiry date after approval
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('membership_id')->references('id')->on('pending_memberships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_renewals');
    }
};
