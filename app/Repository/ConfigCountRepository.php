<?php

namespace App\Repository;

use App\Interfaces\ConfigCountInterface;
use App\Models\ConfigCount;
use App\Models\Package;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConfigCountRepository implements ConfigCountInterface
{
    public function index($request)
    {
        $type = $request->type;

        if ($type == 'sub') {
            $type_name = 'مشاركة';
        } elseif ($type == 'sec_view') {
            $type_name = 'ثواني المشاهدات';
        } elseif ($type == 'sec_sub') {
            $type_name = 'ثواني الاشتراكات';
        } else {
            $type_name = 'مشاهدة';
        }

        $config_count = ConfigCount::where('type', $type);

        if ($request->ajax()) {
            $collect = $config_count->get();
            return DataTables::of($collect)
                ->addColumn('action', function ($config_count) use ($type) {
                    return '
                    <a href="' . route('config_count.edit', [$config_count->id, 'type' => $type]) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                    <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                        data-id="' . $config_count->id . '" data-title="' . $config_count->type . '">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
                })
                ->editColumn('type', function ($config_count) {
                    if ($config_count->type == 'sub')
                        return 'مشاركة';
                    elseif ($config_count->type == 'sec_view')
                        return 'ثواني المشاهدات';
                    elseif ($config_count->type == 'sec_sub')
                        return 'ثواني الاشتراكات';
                    else
                        return 'مشاهدة';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
        return view('admin/config_count/index', compact('type', 'type_name'));
        }

    }


    public function showCreate($request)
    {
        $type = $request->type;
        return view('admin/config_count/parts/create', compact('type'));
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
        $config_count = ConfigCount::query()->findOrFail($id);

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
