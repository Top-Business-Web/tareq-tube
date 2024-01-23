<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Exceptions\MissingPaymentInfoException;

class PaymentController extends Controller
{
    /**
     * @throws MissingPaymentInfoException
     */
    public function payment_verify(Request $request)
    {
        // handle requests
        $amount = $request->amount ?? 200;
        $user_id = $request->user_id ?? 1;
        $user_first_name = $request->user_first_name ?? 'test';
        $user_last_name = $request->user_last_name ?? 'test';
        $user_email = $request->user_email ?? 'test@test.com';
        $user_phone = $request->user_phone ?? '01122717960';
        $source = $request->source ?? 'test.com';

        $payment = new PaymobPayment();

        //pay function
        $payment->pay(
            $amount,
            $user_id,
            $user_first_name,
            $user_last_name,
            $user_email,
            $user_phone,
            $source
        );
        //verify function
        $payment->verify($request);

    }
}
