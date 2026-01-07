<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Auth Routes
Route::post('/register', [App\Http\Controllers\RegisterUserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth Routes (Protected)
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

    // Appointment Routes
    Route::post('/appointments/book', [App\Http\Controllers\AppointmentController::class, 'book']);
    Route::post('/appointments/{appointment}/approve', [App\Http\Controllers\AppointmentController::class, 'approve']);
    Route::post('/appointments/{appointment}/reject', [App\Http\Controllers\AppointmentController::class, 'reject']);

    // Medical Record Routes
    Route::post('/medical-records', [App\Http\Controllers\MedicalRecordController::class, 'create']);
    Route::put('/medical-records/{id}', [App\Http\Controllers\MedicalRecordController::class, 'update']);
    Route::get('/medical-records/doctor', [App\Http\Controllers\MedicalRecordController::class, 'Doctorsview']);
    Route::get('/medical-records/patient', [App\Http\Controllers\MedicalRecordController::class, 'Patientsview']);

    // Dashboard Routes
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
});
