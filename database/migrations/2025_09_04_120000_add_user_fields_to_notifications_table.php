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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('user_email')->nullable()->after('is_read');
            $table->unsignedBigInteger('membership_id')->nullable()->after('user_email');
            $table->string('notification_type')->nullable()->after('membership_id');

            // Add index for better performance when querying by user_email
            $table->index('user_email');
            $table->index('notification_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_email']);
            $table->dropIndex(['notification_type']);
            $table->dropColumn(['user_email', 'membership_id', 'notification_type']);
        });
    }
};
