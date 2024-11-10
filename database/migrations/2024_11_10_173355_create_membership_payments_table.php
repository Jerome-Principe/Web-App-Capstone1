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
            $table->string('gcash_number');
            $table->string('account_name');
            $table->string('reference_number')->unique();
            $table->string('proof_of_payment_url');
            $table->timestamps();
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
