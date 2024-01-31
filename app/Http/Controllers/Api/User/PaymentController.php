<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Interfaces\Api\User\PaymentRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected PaymentRepositoryInterface $paymentRepository;

    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    #|> Payment to get iframe
    public function goPay(Request $request)
    {
        return $this->paymentRepository->goPay($request);
    } // end goPay

    #|> callback function for paymob payment
    public function callback(Request $request)
    {
        return $this->paymentRepository->callback($request);
    } // end callback

    #|> checkout && endpoint for paymob payment
    public function checkout(array $data)
    {
        return $this->paymentRepository->checkout($data);
    }
} // Payment Controller
