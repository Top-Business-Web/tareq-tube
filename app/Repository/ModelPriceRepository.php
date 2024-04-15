<?php

namespace App\Repository;

use App\Interfaces\ModelPriceInterface;
use App\Models\ModelPrice;
use App\Models\Package;
use Yajra\DataTables\DataTables;

class ModelPriceRepository implements ModelPriceInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $model_prices = ModelPrice::get();
            return DataTables::of($model_prices)
                ->addColumn('action', function ($model_prices) {
                    return '
                            <a href="' . route('modelPrice.edit', $model_prices->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                data-id="' . $model_prices->id . '" data-title="' . $model_prices->type . '">
                                <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('type', function ($model_prices) {
                    // Create a button based on the type

                    return $model_prices->type == 'msg' ? '<h4>باقة الرسائل</h4>' : '<h4>باقة النقاط</h4>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/model_prices/index');
        }
    }

    public function showCreate()
    {
        return view('admin/model_prices/parts/create');
    }

    public function storeModelPrice($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createModelPrice($inputs)) {
                toastr()->addSuccess('تم اضافة سعر الباقة بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createModelPrice($inputs)
    {
        return ModelPrice::create($inputs);
    }

    public function showEditModelPrice($id)
    {
        $model_price = ModelPrice::findOrFail($id);

        $modelPriceData = $model_price->only(['id', 'type', 'count', 'price']);

        return view('admin/model_prices/parts/edit', compact('modelPriceData'));
    }

    public function updateModelPrice($request, $id)
    {
        try {
            $model_price = ModelPrice::findOrFail($id);

            $inputs = $request->except('id');

            $model_price->update($inputs);

            toastr()->addSuccess('تم التعديل سعر الباقة بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteModelPrice($request)
    {
        $model_price = ModelPrice::findOrFail($request->id);
            $model_price->delete();
            return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

}
