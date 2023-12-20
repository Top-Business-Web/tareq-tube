<?php

namespace App\Repository;

use App\Interfaces\CityInterface;
use App\Models\City;
use Yajra\DataTables\DataTables;

class CityRepository implements CityInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $citites = City::get();
            return DataTables::of($citites)
                ->addColumn('action', function ($citites) {
                    return '
                            <a href="' . route('city.edit', $citites->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('city.delete', $citites->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/cities/index');
        }
    }

    public function showCreate()
    {
        return view('admin/cities/parts/create');
    }

    public function storeCity($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createCity($inputs)) {
                toastr()->addSuccess('تم اضافة المدينة بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createCity($inputs)
    {
        return City::create($inputs);
    }

    public function showEditCity($id)
    {
        $city = City::findOrFail($id);

        $cityData = $city->only(['id', 'name']);

        return view('admin/cities/parts/edit', compact('cityData'));
    }

    public function updateCity($request, $id)
    {
        try {
            $city = City::findOrFail($id);

            $inputs = $request->except('id');

            $city->update($inputs);

            toastr()->addSuccess('تم التعديل المدينة بنجاح');
            return redirect()->back();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            toastr()->addError('المستخدم غير موجود');
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteCity($request)
    {
        $city = City::findOrFail($request->id);

        $city->delete();
        toastr()->addSuccess("تم حذف المدينة بنجاح");
        return redirect()->back();
    }
}
