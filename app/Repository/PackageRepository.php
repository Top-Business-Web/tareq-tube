<?php

namespace App\Repository;

use App\Interfaces\PackageInterface;
use App\Models\Package;
use Yajra\DataTables\DataTables;

class PackageRepository implements PackageInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $packages = Package::get();
            return DataTables::of($packages)
                ->addColumn('action', function ($packages) {
                    return '
                            <a href="' . route('package.edit', $packages->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                        data-id="' . $packages->id . '" data-title="' . $packages->name . '">
                                        <i class="fas fa-trash"></i>
                                </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/packages/index');
        }
    }

    public function showCreate()
    {
        return view('admin/packages/parts/create');
    }

    public function storePackage($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createPackage($inputs)) {
                toastr()->addSuccess('تم اضافة الباقة بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createPackage($inputs)
    {
        return Package::create($inputs);
    }

    public function showEditPage($id)
    {
        $package = Package::findOrFail($id);

        $packageData = $package->only(['id', 'name', 'price', 'days']);

        return view('admin/packages/parts/edit', compact('packageData'));
    }

    public function updatePackage($request, $id)
    {
        try {
            $package = Package::findOrFail($id);

            $inputs = $request->except('id');

            $package->update($inputs);

            toastr()->addSuccess('تم التعديل الباقة بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deletePackage($request)
    {
        // Find the admin user by ID
        $package = Package::findOrFail($request->id);

        // Delete the admin user
        $package->delete();

        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}
