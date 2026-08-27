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
        Schema::table('machine_defects', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['machine_id']);

            // Add the new foreign key constraint with cascading deletes
            $table->foreign('machine_id')
                ->references('id')
                ->on('machines')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('machine_defects', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['machine_id']);

            // Restore the original foreign key constraint without cascade
            $table->foreign('machine_id')
                ->references('id')
                ->on('machines');
        });
    }
};
