<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'gmail'     => 'required|email|unique:users,gmail,'.$this->id,
            'name'      => 'required',
            'password'  => 'required_without:id'.request()->isMethod('put') ? '' : '|min:6',
            'image'     => 'mimes:jpeg,jpg,png,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes'                => 'صيغة الصورة غير مسموحة',
            'name.required'              => 'يجب ادخال الاسم',
            'gmail.required'             => 'يجب ادخال الإيميل',
            'gmail.unique'               => 'الإيميل مستخدم من قبل',
            'password.required_without'  => 'يجب ادخال كلمة مرور',
            'password.min'               => 'الحد الادني لكلمة المرور : 6 أحرف',
        ];
    }
}
