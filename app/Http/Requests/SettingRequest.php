<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'logo' => 'sometimes|image',
            'trip_insurance' => 'required',
            'rewards' => 'nullable',
            'about' => 'required',
            'support' => 'required',
            'safety_roles' => 'required',
            'polices' => 'required',
            'km' => 'required',
            'vat' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'اسم التطبيق باللغة العربية مطلوب',
            'name_en.required' => 'اسم التطبيق باللغة الانجليزية مطلوب',
            'logo.required' => 'لوجو التطبيق مطلوب',
            'conditions_ar.required' => 'الشروط والاحكام باللغة العربية مطلوب',
            'conditions_en.required' => 'الشروط والاحكام باللغة الانجليزية مطلوب',
            'shipment_price.required' => 'سعر الشحنه مطلوب',
        ];
    }
}
