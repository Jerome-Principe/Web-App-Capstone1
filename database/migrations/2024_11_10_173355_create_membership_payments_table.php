<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('membership_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id')->nullable()->default(null); // Foreign key for pending_memberships
            $table->string('gcash_number');
            $table->string('account_name');
            $table->string('reference_number')->unique();
            $table->string('proof_of_payment_url');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('membership_id')->references('id')->on('pending_memberships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_payments');
    }
};