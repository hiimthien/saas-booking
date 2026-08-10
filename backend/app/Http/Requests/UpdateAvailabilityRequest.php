<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAvailabilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['working_hours' => 'required|array|size:7', 'working_hours.*.day_of_week' => 'required|integer|min:0|max:6', 'working_hours.*.start_time' => 'nullable|date_format:H:i', 'working_hours.*.end_time' => 'nullable|date_format:H:i', 'working_hours.*.is_closed' => 'required|boolean'];
    }
}
