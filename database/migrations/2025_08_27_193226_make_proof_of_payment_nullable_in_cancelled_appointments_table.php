<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, clean up any problematic data
        DB::statement("UPDATE cancelled_appointments SET proof_of_payment = NULL WHERE proof_of_payment = '' OR proof_of_payment = 'N/A'");

        // Then modify the column to be nullable
        Schema::table('cancelled_appointments', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cancelled_appointments', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable(false)->change();
        });
    }
};
