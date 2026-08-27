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
        if (!Schema::hasTable('cancelled_appointments')) {
            return; // Nothing to update
        }

        Schema::table('cancelled_appointments', function (Blueprint $table) {
            // Safely drop existing foreign key if it points to users table
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // ignore if the FK name is different or not present
            }

            // Recreate FK referencing pending_memberships (mobile auth provider)
            $table->foreign('user_id')
                ->references('id')
                ->on('pending_memberships')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('cancelled_appointments')) {
            return;
        }

        Schema::table('cancelled_appointments', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {
                // ignore
            }

            // Restore FK back to users table if needed
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};


