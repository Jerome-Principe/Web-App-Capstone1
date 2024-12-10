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
        Schema::table('request_memberships', function (Blueprint $table) {
            $table->dropForeign(['membership_id']); // Drop the existing foreign key
            $table->foreign('membership_id')->references('id')->on('pending_memberships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_memberships', function (Blueprint $table) {
            $table->dropForeign(['membership_id']); // Drop the foreign key with cascade
            $table->foreign('membership_id')->references('id')->on('pending_memberships'); // Re-add without cascade
        });
    }
};
