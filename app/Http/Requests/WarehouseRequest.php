<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'name_ar' => 'required|unique:warehouses,name_ar,' . $this->id,
            'name_en' => 'required|unique:warehouses,name_en,' . $this->id,
            'city_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'اسم المخزن باللغة العربية مطلوب',
            'name_en.required' => 'اسم المخزن باللغة الانجليزية مطلوب',
            'name_ar.unique' => 'اسم المدينة باللغة العربية موجود من قبل',
            'name_en.unique' => 'اسم المدينة باللغة الانجليزية موجود من قبل',
            'city_id.required' => 'برجاء اختيار المدينة ',

        ];
    }
}
