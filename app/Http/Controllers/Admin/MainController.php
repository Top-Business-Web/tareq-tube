<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserAction;
use Twilio\Rest\Client;

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

    public function sendVerificationCode($phoneNumber)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $twilioNumber = env('TWILIO_PHONE');

        $twilio = new Client($sid, $token);


            $twilio->messages->create(
                $phoneNumber,
                [
                    'from' => $twilioNumber,
                    'body' => 'Hiii',
                ]
            );

            return true;
    }
}//end class
