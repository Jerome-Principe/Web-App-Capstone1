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
        Schema::create('walkins', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->date('date');
            $table->time('time');
            $table->string('gender');
            $table->integer('age');
            $table->string('city');
            $table->string('province');
            $table->string('zipcode');
            $table->decimal('amount', 8, 2);
            $table->string('payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walkins');
    }
};
