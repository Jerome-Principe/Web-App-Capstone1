<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rfids', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('rfid')->nullable();
            $table->time('time_in')->nullable();
            $table->date('date_logged')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rfids');
    }
};
