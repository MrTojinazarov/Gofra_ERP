<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'sometimes|string|max:15',
            'address' => 'sometimes|string|max:255',
            'section_id' => 'sometimes|exists:sections,id',
            'user_id' => 'sometimes|exists:users,id',
            'salary' => 'sometimes|numeric|min:0',
            'salary_type_id' => 'sometimes|exists:salary_types,id',
            'month_time' => 'sometimes|numeric|min:0',
            'start_time' => 'sometimes|date_format:H:i:s',
            'end_time' => 'sometimes|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'phone.string' => 'The phone number must be a valid string.',
            'phone.max' => 'The phone number cannot exceed 15 characters.',
            'address.string' => 'The address must be a valid string.',
            'address.max' => 'The address cannot exceed 255 characters.',
            'section_id.exists' => 'The selected section does not exist.',
            'user_id.exists' => 'The selected user does not exist.',
            'salary.numeric' => 'The salary must be a valid number.',
            'salary.min' => 'The salary must be at least 0.',
            'salary_type_id.exists' => 'The selected salary type does not exist.',
            'month_time.numeric' => 'The month time must be a valid number.',
            'month_time.min' => 'The month time must be at least 0.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
        ];
    }
}
