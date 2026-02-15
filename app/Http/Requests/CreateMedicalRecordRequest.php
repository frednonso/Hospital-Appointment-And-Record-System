<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMedicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'patient_id' => 'required|integer|exists:users,id',
            // 'doctor_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'diagnosis' => 'nullable|string|max:1000',
            'symptoms' => 'nullable|string|max:1000',
            'treatment_plan' => 'nullable|string|max:2000',
            'medications' => 'nullable|string|max:1000',
            'record_date' => 'required|date|before_or_equal:today',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ];
    }
}
