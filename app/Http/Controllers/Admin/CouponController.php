<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CouponInterface;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private CouponInterface $couponInterface;

    public function __construct(CouponInterface $couponInterface)
    {
        $this->couponInterface = $couponInterface;
    }

    public function index(Request $request)
    {
        return $this->couponInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->couponInterface->showCreate($request);
    }

    public function storeCoupon(Request $request)
    {
        return $this->couponInterface->storeCoupon($request);
    }

    public function showEditCoupon($id)
    {
        return $this->couponInterface->showEditCoupon($id);
    }

    public function updateCoupon(Request $request, $id)
    {
        return $this->couponInterface->updateCoupon($request, $id);
    }

    public function deleteCoupon(Request $request)
    {
        return $this->couponInterface->deleteCoupon($request);
    }
}
