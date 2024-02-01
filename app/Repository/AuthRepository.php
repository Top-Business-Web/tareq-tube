<?php

namespace App\Repository;

use App\Interfaces\AuthInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthRepository implements AuthInterface
{
    public function index()
    {
        if (Auth::guard('user')->check()) {
            return redirect('admin');
        }
        return view('admin.auth.login');
    }

    public function login($request)
    {
        $validator = Validator::make($request->all(), [
            'gmail' => 'required|exists:users,gmail',
            'password' => 'required'
        ], [
            'gmail.exists' => 'هذا البريد غير مسجل معنا',
            'gmail.required' => 'يرجي ادخال البريد الالكتروني',
            'password.required' => 'يرجي ادخال كلمة المرور',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            foreach ($errors as $error) {
                toastr()->addError($error);
            }
            return redirect()->back();
        }

        if (Auth::guard('user')->attempt(['gmail' => $request->gmail, 'password' => $request->password])) {
            toastr()->addSuccess('تم تسجيل الدخول بنجاح');
            return redirect()->route('adminHome');
        }
        toastr()->addError('هناك خطا في البيانات');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        toastr()->addInfo('تم تسجيل الخروج');
        return redirect('admin/login');
    }
}
