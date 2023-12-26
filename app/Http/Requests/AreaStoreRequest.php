<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'city_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المنطقة مطلوب',
            'city_id.required' => 'اسم المدينة مطلوب',
        ];
    }
}
