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
        Schema::table('pending_appointments', function (Blueprint $table) {
            $table->decimal('instructor_rate', 10, 2)->nullable()->after('status');
            $table->decimal('gym_rate', 10, 2)->nullable()->after('instructor_rate');
            $table->decimal('total_amount', 10, 2)->nullable()->after('gym_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_appointments', function (Blueprint $table) {
            $table->dropColumn(['instructor_rate', 'gym_rate', 'total_amount']);
        });
    }
};
