<?php

namespace App\Repository;

use App\Interfaces\PackageUserInterface;
use App\Models\PackageUser;
use Yajra\DataTables\DataTables;

class PackageUserRepository implements PackageUserInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $packages_users = PackageUser::get();
            return DataTables::of($packages_users)
                ->addColumn('action', function ($packages_users) {
                    return '
                            <a href="' . route('package_user.delete', $packages_users->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('package_id', function($packages_users) {
                    return $packages_users->package->name;
                })
                ->editColumn('user_id', function($packages_users) {
                    return $packages_users->user->name;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/packages_users/index');
        }
    }

    public function deletePackageUser($request)
    {
        $package_user = PackageUser::findOrFail($request->id);

            $package_user->delete();
            toastr()->addSuccess("تم حذف الباقة بنجاح");
            return redirect()->back();
    }

}