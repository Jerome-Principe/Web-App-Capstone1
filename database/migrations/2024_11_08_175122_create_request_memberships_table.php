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
        Schema::create('request_memberships', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('date');
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->string('address');
            $table->string('postal_code');
            $table->string('email')->unique();
            $table->string('work')->nullable();
            $table->string('mobile');
            $table->string('gym_source')->nullable();
            $table->string('membership_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_memberships');
    }
};
