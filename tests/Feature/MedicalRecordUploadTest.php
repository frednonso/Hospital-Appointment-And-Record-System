<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MedicalRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MedicalRecordUploadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_doctor_can_create_a_medical_record_with_an_attachment()
    {
        Storage::fake('public');

        $doctor = User::factory()->create(['role' => 'doctor']);
        $patient = User::factory()->create(['role' => 'patient']);

        $file = UploadedFile::fake()->create('medical_report.pdf', 100);

        $recordData = [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'title' => 'General Checkup',
            'diagnosis' => 'Healthy',
            'symptoms' => 'None',
            'treatment_plan' => 'Maintain healthy diet',
            'medications' => 'Multivitamins',
            'record_date' => now()->format('Y-m-d'),
            'attachment' => $file
        ];

        Sanctum::actingAs($doctor);
        $response = $this->postJson('/api/medical-records', $recordData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'medical record created succesfully'
            ]);

        $this->assertDatabaseHas('medical_records', [
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'title' => 'General Checkup'
        ]);

        $record = MedicalRecord::first();
        $this->assertNotNull($record->attachment_path);
        
        Storage::disk('public')->assertExists($record->attachment_path);
    }

    /** @test */
    public function a_patient_cannot_create_a_medical_record()
    {
        $patient = User::factory()->create(['role' => 'patient']);
        $otherPatient = User::factory()->create(['role' => 'patient']);

        $recordData = [
            'patient_id' => $otherPatient->id,
            'doctor_id' => 1, // Dummy ID
            'title' => 'Unauthorized Record',
            'record_date' => now()->format('Y-m-d'),
        ];

        Sanctum::actingAs($patient);
        $response = $this->postJson('/api/medical-records', $recordData);

        // MedicalRecordService throws AuthorizationException which usually results in 403
        $response->assertStatus(403);
    }
}
