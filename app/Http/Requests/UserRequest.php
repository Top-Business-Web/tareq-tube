<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email'     => 'email|unique:users,email,'.$this->id,
            'name'      => 'required',
            'password'  => 'required_without:id'.request()->isMethod('put') ? '' : '|min:6',
            'image'     => 'required_without:id'.request()->isMethod('put') ? '' : '|mimes:jpeg,jpg,png,gif,webp',
            'phone'     => 'unique:users,phone,'.$this->id,
            'national_id'     => 'unique:users,national_id,'.$this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'image.mimes'                => 'صيغة الصورة غير مسموحة',
            'image.required'                => ' الصورة مطلوبة',
            'email.unique'               => 'الإيميل مستخدم من قبل',
            'phone.unique'               => 'الهاتف مستخدم من قبل',
            'national_id.unique'               => 'رقم الهوية مستخدم من قبل',
            'password.required_without'  => 'يجب ادخال كلمة مرور',
            'password.min'               => 'الحد الادني لكلمة المرور : 6 أحرف',
        ];
    }
}
