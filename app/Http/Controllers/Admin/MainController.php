<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserAction;

class MainController extends Controller
{
    public function index()
    {
        $data['user_count'] = User::count();
        $data['watch_count'] = UserAction::where('type','view')->count();
        $data['sub_count'] = UserAction::where('type','sub')->count();
        $data['payment_count'] = Payment::count();
        return view('admin/index',$data);
    }
}//end class
