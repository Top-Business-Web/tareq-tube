<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentTransactionInterface;

class PaymentTransactionController extends Controller
{
    private PaymentTransactionInterface $paymentTransactionInterface;

    public function __construct(PaymentTransactionInterface $paymentTransactionInterface)
    {
        $this->paymentTransactionInterface = $paymentTransactionInterface;
    }

    public function index(Request $request)
    {
        return $this->paymentTransactionInterface->index($request);
    }

    public function delete(Request $request)
    {
        return $this->paymentTransactionInterface->delete($request);
    }
}
