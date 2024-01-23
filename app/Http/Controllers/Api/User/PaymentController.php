<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nafezly\Payments\Classes\FawryPayment;
use Nafezly\Payments\Classes\PaymobWalletPayment;

class PaymentController extends Controller
{
    public function payment_verify(Request $request)
    {
        $amount = $request->amount;
        $user_id = $request->user_id;
        $user_first_name = $request->user_first_name;
        $user_last_name = $request->user_last_name;
        $user_email = $request->user_email;
        $user_phone = $request->user_phone;
        $source = $request->source;

        $payment = new FawryPayment();

        //pay function
        $payment->pay(
            $amount,
            $user_id = null,
            $user_first_name = null,
            $user_last_name = null,
            $user_email = null,
            $user_phone = null,
            $source = null
        );

        //verify function
        $payment->verify($request);

    }
}
