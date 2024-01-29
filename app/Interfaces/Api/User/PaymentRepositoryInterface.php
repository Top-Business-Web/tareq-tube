<?php

namespace App\Interfaces\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface PaymentRepositoryInterface
{
    public function goPay(Request $request);
    public function pay(array $data): JsonResponse;
    public function callback(Request $request);
    public function checkout(array $data);
}
//Made By https://github.com/eldapour (eldapour)
