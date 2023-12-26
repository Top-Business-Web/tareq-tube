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
                            <a href="' . route('modelPrice.delete', $model_prices->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('type', function ($model_prices) {
                    // Create a button based on the type
                    $buttonStyle = $model_prices->type == 'msg' ? 'background-color: #333333; color: #ffffff; border: 1px solid #333333;' : 'background-color: #ff5555; color: #ffffff; border: 1px solid #ff5555;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">' . ($model_prices->type == 'msg' ? 'Message' : 'Points') . '</button>';
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
            toastr()->addSuccess("تم حذف سعر الباقة بنجاح");
            return redirect()->back();
    }

}