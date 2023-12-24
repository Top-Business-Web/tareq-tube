<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
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
            'image' => 'required|image',
            'link' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => 'الصورة مطلوبة',
            'image.image' => 'يجب ان تكون صورة',
            'link.required' => 'الرابط مطلوب',
        ];
    }
}
