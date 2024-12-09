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
        Schema::table('medical_forms', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['membership_id']);

            // Re-add the foreign key with ON DELETE CASCADE
            $table->foreign('membership_id')
                ->references('id')->on('pending_memberships')
                ->cascadeOnDelete(); // Proper method to apply ON DELETE CASCADE
        });

        Schema::table('membership_payments', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['membership_id']);

            // Re-add the foreign key with ON DELETE CASCADE
            $table->foreign('membership_id')
                ->references('id')->on('pending_memberships')
                ->cascadeOnDelete(); // Proper method to apply ON DELETE CASCADE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_forms', function (Blueprint $table) {
            // Drop the ON DELETE CASCADE foreign key
            $table->dropForeign(['membership_id']);

            // Add the previous foreign key without ON DELETE CASCADE
            $table->foreign('membership_id')
                ->references('id')->on('pending_memberships')
                ->nullOnDelete(); // Adjust based on previous behavior
        });

        Schema::table('membership_payments', function (Blueprint $table) {
            // Drop the ON DELETE CASCADE foreign key
            $table->dropForeign(['membership_id']);

            // Add the previous foreign key without ON DELETE CASCADE
            $table->foreign('membership_id')
                ->references('id')->on('pending_memberships')
                ->nullOnDelete(); // Adjust based on previous behavior
        });
    }
};