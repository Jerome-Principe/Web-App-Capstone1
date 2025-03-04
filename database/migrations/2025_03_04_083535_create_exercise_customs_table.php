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
        Schema::create('exercise_customs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pending_memberships')->onDelete('cascade');
            $table->string('category');
            $table->string('type');
            $table->text('guideline');
            $table->string('exercise')->nullable();
            $table->text('description')->nullable();
            $table->string('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_customs');
    }
};
