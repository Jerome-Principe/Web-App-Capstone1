<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_programs', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('type');
            $table->text('guideline');
            $table->string('day');
            $table->text('workout');
            $table->string('difficulty');
            $table->string('duration');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_programs');
    }
};
