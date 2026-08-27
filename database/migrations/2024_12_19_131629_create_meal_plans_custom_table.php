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
        Schema::create('meal_plans_custom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pending_memberships')->onDelete('cascade');
            $table->string('category');
            $table->string('type');
            $table->text('guideline')->nullable();
            $table->string('day')->nullable();
            $table->text('breakfast')->nullable();
            $table->text('lunch')->nullable();
            $table->text('dinner')->nullable();
            $table->enum('progress', ['Incomplete', 'Completed'])->default('Incomplete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans_custom');
    }
};