<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'materials.*.material_id' => 'required|exists:materials,id',
            'materials.*.value' => 'required|numeric|min:0.1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Mahsulot nomi kiritilishi shart.',
            'name.string' => 'Mahsulot nomi faqat harflardan iborat bo‘lishi kerak.',
            'name.max' => 'Mahsulot nomi 255 ta belgidan oshmasligi kerak.',
            'image.image' => 'Rasm fayl turi bo‘lishi kerak (jpg, png, jpeg, gif, svg).',
            'image.max' => 'Rasm hajmi 2MB dan oshmasligi kerak.',
            'materials.*.material_id.required' => 'Material tanlash majburiy.',
            'materials.*.material_id.exists' => 'Tanlangan material mavjud emas.',
            'materials.*.value.required' => 'Material miqdori kiritilishi shart.',
            'materials.*.value.numeric' => 'Material miqdori son bo‘lishi kerak.',
            'materials.*.value.min' => 'Material miqdori 0.1 dan kam bo‘lishi mumkin emas.',
        ];
    }
}
