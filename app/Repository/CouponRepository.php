<?php

namespace App\Repository;

use App\Interfaces\CouponInterface;
use App\Models\Coupon;
use App\Models\Package;
use Yajra\DataTables\DataTables;

class CouponRepository implements CouponInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $coupons = Coupon::get();
            return DataTables::of($coupons)
                ->addColumn('action', function ($coupons) {
                    return '
                            <a href="' . route('coupon.edit', $coupons->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('coupon.delete', $coupons->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/coupons/index');
        }
    }

    public function showCreate()
    {
        return view('admin/coupons/parts/create');
    }

    public function storeCoupon($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createCoupon($inputs)) {
                toastr()->addSuccess('تم اضافة الكوبون بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createCoupon($inputs)
    {
        return Coupon::create($inputs);
    }

    public function showEditCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);

        $couponData = $coupon->only(['id', 'code', 'points', 'limit']);

        return view('admin/coupons/parts/edit', compact('couponData'));
    }

    public function updateCoupon($request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $inputs = $request->except('id');

            $coupon->update($inputs);

            toastr()->addSuccess('تم التعديل الكوبون بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteCoupon($request)
    {
        $coupon = Coupon::findOrFail($request->id);

            $coupon->delete();
            toastr()->addSuccess("تم حذف الكوبون بنجاح");
            return redirect()->back();
    }

}