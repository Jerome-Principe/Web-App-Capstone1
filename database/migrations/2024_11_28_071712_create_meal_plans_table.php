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
        Schema::create('meal_plans', function (Blueprint $table) {
            $table->id();
            $table->string('guideline')->nullable(); // For general guidelines
            $table->string('day')->nullable(); // Day of the week
            $table->string('breakfast')->nullable(); // Breakfast
            $table->string('lunch')->nullable(); // Lunch
            $table->string('dinner')->nullable(); // Dinner
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
