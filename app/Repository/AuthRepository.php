<?php

namespace App\Repository;

use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validate(
            [
                'gmail' => 'required|exists:users,gmail',
                'password' => 'required'
            ],
            [
                'gmail.exists' => 'هذا البريد غير مسجل معنا',
                'gmail.required' => 'يرجي ادخال البريد الالكتروني',
                'password.required' => 'يرجي ادخال كلمة المرور',
            ]
        );
        if (Auth::guard('user')->attempt($data)) {
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
