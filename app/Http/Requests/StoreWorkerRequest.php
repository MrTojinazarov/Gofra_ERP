<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
            'user_id' => 'required|exists:users,id',
            'salary' => 'required|numeric|min:0',
            'salary_type_id' => 'required|exists:salary_types,id',
            'month_time' => 'required|numeric|min:0',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a valid string.',
            'phone.max' => 'The phone number cannot exceed 15 characters.',
            'address.required' => 'The address is required.',
            'address.string' => 'The address must be a valid string.',
            'address.max' => 'The address cannot exceed 255 characters.',
            'section_id.required' => 'The section selection is required.',
            'section_id.exists' => 'The selected section does not exist.',
            'user_id.required' => 'The user selection is required.',
            'user_id.exists' => 'The selected user does not exist.',
            'salary.required' => 'The salary amount is required.',
            'salary.numeric' => 'The salary must be a valid number.',
            'salary.min' => 'The salary must be at least 0.',
            'salary_type_id.required' => 'The salary type selection is required.',
            'salary_type_id.exists' => 'The selected salary type does not exist.',
            'month_time.required' => 'The month time is required.',
            'month_time.numeric' => 'The month time must be a valid number.',
            'month_time.min' => 'The month time must be at least 0.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
        ];
    }
}
