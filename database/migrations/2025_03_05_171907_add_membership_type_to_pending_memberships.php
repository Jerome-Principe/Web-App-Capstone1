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
            $table->string('membership_type')->nullable()->after('expiry_date');
        });
    }

    public function down()
    {
        Schema::table('pending_memberships', function (Blueprint $table) {
            $table->dropColumn('membership_type');
        });
    }

};
