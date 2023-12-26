<?php

namespace App\Repository;

use App\Interfaces\InterestInterface;
use App\Models\Interest;
use Yajra\DataTables\DataTables;

class InterestRepository implements InterestInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $interests = Interest::get();
            return DataTables::of($interests)
                ->addColumn('action', function ($interests) {
                    return '
                            <a href="' . route('interest.edit', $interests->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('interest.delete', $interests->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/interests/index');
        }
    }

    public function showCreate()
    {
        return view('admin/interests/parts/create');
    }

    public function storeInterest($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createInterest($inputs)) {
                toastr()->addSuccess('تم اضافة الاهتمام بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createInterest($inputs)
    {
        return Interest::create($inputs);
    }

    public function showEditInterest($id)
    {
        $interest = Interest::findOrFail($id);

        $interestData = $interest->only(['id', 'name']);

        return view('admin/interests/parts/edit', compact('interestData'));
    }

    public function updateInterest($request, $id)
    {
        try {
            $interest = Interest::findOrFail($id);

            $inputs = $request->except('id');

            $interest->update($inputs);

            toastr()->addSuccess('تم التعديل الاهتمام بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteInterest($request)
    {
        $interest = Interest::findOrFail($request->id);

        $interest->delete();
        toastr()->addSuccess("تم حذف الاهتمام بنجاح");
        return redirect()->back();
    }
}
