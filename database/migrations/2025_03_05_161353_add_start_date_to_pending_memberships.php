<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pending_memberships', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('status'); // Adjust placement as needed
        });
    }

    public function down()
    {
        Schema::table('pending_memberships', function (Blueprint $table) {
            $table->dropColumn('start_date');
        });
    }

};
