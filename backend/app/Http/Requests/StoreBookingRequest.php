<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        // For now, allow anyone. In production, check if user is logged in.
        return true;
    }

    public function rules(): array
    {
        return [
            'consultant_profile_id' => ['required', 'exists:consultant_profiles,id'],
            'start_time' => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:180'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
