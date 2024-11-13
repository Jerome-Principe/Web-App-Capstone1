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
        Schema::create('medical_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membership_id')->nullable()->default(null); // Foreign key for pending_memberships
            $table->string('emergency_contact');
            $table->string('relationship');
            $table->string('emergency_number');
            $table->string('pregnant')->nullable();
            $table->string('weeks_pregnant')->nullable();
            $table->string('physical_activities')->nullable();
            $table->string('smoke_details')->nullable();
            $table->string('medication_details')->nullable();

            // Checkboxes
            $table->boolean('heart_disease')->default(false);
            $table->boolean('asthma')->default(false);
            $table->boolean('gout')->default(false);
            $table->boolean('cardiovascular_condition')->default(false);
            $table->boolean('high_blood_pressure')->default(false);
            $table->boolean('dizziness')->default(false);
            $table->boolean('arthritis')->default(false);
            $table->boolean('infectious_disease')->default(false);
            $table->boolean('black_outs')->default(false);
            $table->boolean('diabetes')->default(false);
            $table->boolean('fainting')->default(false);
            $table->boolean('epilepsy')->default(false);
            $table->string('other_condition1')->nullable();

            $table->boolean('knees')->default(false);
            $table->boolean('lower_back')->default(false);
            $table->boolean('neck')->default(false);
            $table->boolean('shoulders')->default(false);
            $table->boolean('hips')->default(false);
            $table->boolean('pelvis')->default(false);
            $table->boolean('flexibility')->default(false);
            $table->string('other_condition2')->nullable();

            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('membership_id')->references('id')->on('pending_memberships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_forms');
    }
};