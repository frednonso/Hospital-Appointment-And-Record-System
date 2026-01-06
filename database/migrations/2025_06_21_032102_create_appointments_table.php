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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['pending', 'approved', 'rejected'])
                ->default('pending');
            $table->text('reason')->nullable(); // Why patient wants appointment
            $table->text('doctor_notes')->nullable(); // Doctor's notes when approving/rejecting
            $table->text('patient_notes')->nullable(); // Additional patient notes

            // Ensure a doctor can't have overlapping appointments
            $table->unique(['doctor_id', 'appointment_date', 'appointment_time']);



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
