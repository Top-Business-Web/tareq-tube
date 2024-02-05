<?php

namespace App\Repository;

use App\Interfaces\ConfigCountInterface;
use App\Models\ConfigCount;
use App\Models\Package;
use Yajra\DataTables\DataTables;

class ConfigCountRepository implements ConfigCountInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $config_count = ConfigCount::get();
            return DataTables::of($config_count)
                ->addColumn('action', function ($config_count) {
                    return '
                            <a href="' . route('config_count.edit', $config_count->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                        data-id="' . $config_count->id . '" data-title="' . $config_count->type . '">
                                        <i class="fas fa-trash"></i>
                                </button>
                       ';
                })
                ->editColumn('type', function ($config_count) {
                    if ($config_count->type == 'sub')
                        return 'مشاركة';
                    elseif ($config_count->type == 'second')
                        return 'ثواني';
                    else
                        return 'مشاهدة';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/config_count/index');
        }
    }

    public function showCreate()
    {
        return view('admin/config_count/parts/create');
    }

    public function storeConfigCount($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createConfigCount($inputs)) {
                toastr()->addSuccess('تم اضافة سعر العملية بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createConfigCount($inputs)
    {
        return ConfigCount::create($inputs);
    }

    public function showEditConfigCount($id)
    {
        $config_count = ConfigCount::findOrFail($id);

        $configCountData = $config_count->only(['id', 'type', 'count', 'point']);

        return view('admin/config_count/parts/edit', compact('configCountData'));
    }

    public function updateConfigCount($request, $id)
    {
        try {
            $config_count = ConfigCount::findOrFail($id);

            $inputs = $request->except('id');

            $config_count->update($inputs);

            toastr()->addSuccess('تم التعديل سعر العملية بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteConfigCount($request)
    {
        $config_count = ConfigCount::findOrFail($request->id);

        $config_count->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}
