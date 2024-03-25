<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\MessageInterface;
use App\Interfaces\WithdrawInterface;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    private WithdrawInterface $withdraw;

    public function __construct(WithdrawInterface $withdraw)
    {
        $this->withdraw = $withdraw;
    }

    public function index(Request $request)
    {
        return $this->withdraw->index($request);
    }

    public function deleteWithdraw(Request $request)
    {
        return $this->withdraw->deleteWithdraw($request);
    }
}
