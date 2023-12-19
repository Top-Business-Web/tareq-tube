<?php

namespace App\Repository;

use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Interfaces\AdminInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminRepository implements AdminInterface
{

    public function index($request)
    {
        if ($request->ajax()) {
            $admins = User::where('is_admin', '1')->get();
            return DataTables::of($admins)
                ->addColumn('action', function ($admins) {
                    return '
                            <a href="' . route('admin.edit', $admins->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('delete.admin', $admins->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('image', function ($admins) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . asset('storage/' . $admins->image) . '">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/admin/index');
        }
    }

    public function showCreate()
    {
        return view('admin/admin/parts/create');
    }


    public function delete($request)
    {
        // Find the admin user by ID
        $admin = User::findOrFail($request->id);

        // Check if the admin to be deleted is the currently authenticated user
        if ($admin->id === auth()->guard('user')->id()) {
            return response(['message' => "لا يمكن حذف المشرف المسجل به!", 'status' => 501], 200);
        } else {
            // Check if the image file exists before attempting to delete it
            if (file_exists($admin->image)) {
                unlink($admin->image);
            }

            // Delete the admin user
            $admin->delete();

            // Show a sweet alert with a cancel button
            toastr()->addSuccess("تم حذف المشرف بنجاح", 'green');

            // Redirect back after deletion
            return redirect()->back();
        }
    }

    public function myProfile()
    {
        $admin = auth()->guard('user')->user();
        return view('admin/admin/profile', compact('admin'));
    } //end fun


    public function create()
    {
        return view('admin/admin.parts.create');
    }

    public function storeAdmin($request)
    {
        try {
            $inputs = $this->processInputs($request);

            $this->uploadImage($request, $inputs);

            if ($this->createAdminUser($inputs)) {
                toastr()->addSuccess('تم اضافة الادمن بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function processInputs($request)
    {
        return array_merge(
            $request->except(['image', 'password']),
            [
                'password' => Hash::make($request->password),
                'is_admin' => 1,
            ]
        );
    }

    private function uploadImage($request, &$inputs)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/admins', 'public');
            $inputs['image'] = $imagePath;
        } else {
            unset($inputs['image']);
        }
    }

    private function createAdminUser($inputs)
    {
        return User::create($inputs);
    }

    public function showEdit($id)
    {
        $user = User::findOrFail($id);

        $userData = $user->only(['id', 'name', 'gmail', 'image', 'password']);

        return view('admin.admin.parts.edit', compact('userData'));
    }

    public function updateAdmin($request, $id)
    {
        try {
            $admin = User::findOrFail($id);

            $inputs = $request->except('id');

            $this->uploadImage($request, $admin);

            $this->handlePasswordUpdate($request, $inputs);

            $admin->update($inputs);

            toastr()->addSuccess('تم التعديل الادمن بنجاح');
            return redirect()->back();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            toastr()->addError('المستخدم غير موجود');
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }


    private function handlePasswordUpdate($request, &$inputs)
    {
        if ($request->filled('password')) {
            $inputs['password'] = Hash::make($request->password);
        } else {
            unset($inputs['password']);
        }
    }
}
