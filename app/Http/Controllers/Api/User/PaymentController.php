<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nafezly\Payments\Classes\FawryPayment;
use Nafezly\Payments\Classes\PaymobPayment;
use Nafezly\Payments\Classes\PaymobWalletPayment;
use Nafezly\Payments\Exceptions\MissingPaymentInfoException;

class PaymentController extends Controller
{
    /**
     * @throws MissingPaymentInfoException
     */
    public function payment_verify(Request $request)
    {
        $amount = $request->amount ?? 200;
        $user_id = $request->user_id ?? 1;
        $user_first_name = $request->user_first_name ?? 'test';
        $user_last_name = $request->user_last_name ?? 'test';
        $user_email = $request->user_email ?? 'test@test.com';
        $user_phone = $request->user_phone ?? '01122717960';
        $source = $request->source ?? 'test.com';

        $payment = new PaymobPayment();

        //or use
        $payment->setUserId($user_id)
            ->setUserFirstName($user_first_name)
            ->setUserLastName($user_last_name)
            ->setUserEmail($user_email)
            ->setUserPhone($user_phone)
            ->setCurrency('EG')
            ->setAmount($amount)
            ->pay();

        //verify function
        $payment->verify($request);

    }
}
