<?php

namespace App\Repository;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\PhotoTrait;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements UserInterface
{
    use PhotoTrait;

    public function indexPerson($request)
    {
        if ($request->ajax()) {
            $users = User::query()
            ->where('type', '=', 'user')->latest()->get();
            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $users->id . '" data-title="' . $users->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($users) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . asset($users->img) . '">
                    ';
                })
                ->editColumn('status', function ($users) {
                    if ($users->status == 1)
                        return '<button class="btn btn-sm btn-success statusBtn" data-id="' . $users->id . '">مقبول</button>';
                    else
                        return '<button class="btn btn-sm btn-danger statusBtn" data-id="' . $users->id . '">غير مقبول</button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.user.index_person');
        }
    }


    public function indexCompany($request)
    {
        if ($request->ajax()) {
            $users = User::query()
                ->where('user_type', 'company')->latest()->get();
            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $users->id . '" data-title="' . $users->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($users) {
                    return '
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . asset($users->image) . '">
                    ';
                })
                ->editColumn('status', function ($user) {
                    if ($user->status == 1)
                        return '<button class="btn btn-sm btn-success statusBtn" data-id="' . $user->id . '">مفعل</button>';
                    else
                        return '<button class="btn btn-sm btn-danger statusBtn" data-id="' . $user->id . '">غير مفعل</button>';
                })
                ->editColumn('city_id', function ($user) {
                    return $user->city->name_ar;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.user.index_company');
        }
    }

    public function delete($request)
    {
        $admin = User::where('id', $request->id)->first();

        if (file_exists($admin->image)) {
            unlink($admin->image);
        }
        $admin->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    public function changeStatusUser($request)
    {
        $user = User::findOrFail($request->id);

        ($user->status == 1) ? $user->status = 0 : $user->status = 1;

        $user->save();

        if ($user->status == 1) {
            return response()->json('200');
        } else {
            return response()->json('201');
        }
    }
}
