<?php

namespace App\Interfaces\Api\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface PaymentRepositoryInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function goPay(Request $request): mixed;

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function pay(array $data): JsonResponse;

    /**
     * @param Request $request
     * @return mixed
     */
    public function callback(Request $request): mixed;

    /**
     * @param array $data
     * @return mixed
     */
    public function checkout(array $data): mixed;
}
//Made By https://github.com/eldapour (eldapour)
