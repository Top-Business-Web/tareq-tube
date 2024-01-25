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
       // handle payment

    } // end Payment verify method
} // Payment Controller
