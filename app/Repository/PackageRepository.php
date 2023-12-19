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
                            <a href="' . route('package.delete', $packages->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            toastr()->addError('المستخدم غير موجود');
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

            // Show a sweet alert with a cancel button
            toastr()->addSuccess("تم حذف الباقة بنجاح");

            // Redirect back after deletion
            return redirect()->back();
    }

}