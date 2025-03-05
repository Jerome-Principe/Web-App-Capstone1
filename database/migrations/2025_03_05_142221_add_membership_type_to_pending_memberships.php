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
            if (!Schema::hasColumn('pending_memberships', 'membership_type')) {
                $table->string('membership_type')->default('Standard')->after('password');
            }
        });
    }

    public function down()
    {
        Schema::table('pending_memberships', function (Blueprint $table) {
            if (Schema::hasColumn('pending_memberships', 'membership_type')) {
                $table->dropColumn('membership_type');
            }
        });
    }

};
