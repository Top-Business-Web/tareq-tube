<?php

namespace App\Repository;

use App\Interfaces\BoxInterface;
use App\Models\RewardBox;
use Yajra\DataTables\DataTables;

class BoxRepository implements BoxInterface
{
    public function index($request)
    {
        $boxes = RewardBox::query()->get();
        return view('admin/boxes/index', compact('boxes'));
    }

    public function showCreate()
    {
        return view('admin/boxes/parts/create');
    }

    public function storeBox($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createBox($inputs)) {
                toastr()->addSuccess('تم اضافة المدينة بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createBox($inputs)
    {
        return RewardBox::create($inputs);
    }

    public function showEditBox($id)
    {
        $city = RewardBox::findOrFail($id);

        $cityData = $city->only(['id', 'name']);

        return view('admin/cities/parts/edit', compact('cityData'));
    }

    public function updateBox($request, $id)
    {
        try {
            $box = RewardBox::query()->findOrFail($id);

            $inputs = $request->except('id');

            if ($request->has('gold')){
                $gold = 1;
            }else {
                $gold = 0;
            }

            $box->update([
                'prize' => $request->prize,
                'gold' => $gold,
            ]);

            toastr()->addSuccess('تم التعديل الصندوق بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteBox($request)
    {
        $city = RewardBox::findOrFail($request->id);

        $city->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}
