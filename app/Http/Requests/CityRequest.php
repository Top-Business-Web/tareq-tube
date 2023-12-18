<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:cities,name,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'اسم المدينة باللغة العربية مطلوب',
            'name_ar.unique' => 'اسم المدينة باللغة العربية موجود من قبل',
        ];
    }
}
