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
        Schema::create('pending_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('pending_memberships')->onDelete('cascade'); // Referencing pending_memberships
            $table->string('selected_date');
            $table->string('selected_time');

            // Payment details
            $table->string('payment_method');
            $table->string('gcash_account_name')->nullable();
            $table->string('gcash_account_number')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_appointments');
    }
};