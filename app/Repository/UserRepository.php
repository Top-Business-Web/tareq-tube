<?php

namespace App\Repository;

use App\Interfaces\UserInterface;
use App\Models\User;
use App\Repository\Api\ResponseApi;
use App\Traits\PhotoTrait;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserRepository extends ResponseApi implements UserInterface
{
    use PhotoTrait;

    public function index($request)
    {
        if ($request->ajax()) {
            $users = User::query()
                ->where('is_admin', '=', '0')->latest()->get();
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
                    <img alt="image" onclick="window.open(this.src)" class="avatar avatar-md rounded-circle" src="' . $users->image . '">
                    ';
                })
                ->editColumn('status', function ($users) {
                    if ($users->status == 1) {
                        $btn = '<button class="btn btn-sm btn-success statusBtn" data-id="' . $users->id . '">
                                    مفعل
                                </button>';
                        if ($users->is_vip == 1) {
                            $btn .= ' <span class="btn btn-sm btn-primary-gradient">حساب VIP</span>';
                        }
                        return $btn;
                    } else {
                        $btn = '<button class="btn btn-sm btn-danger statusBtn" data-id="' . $users->id . '">
                                   غير مفعل
                                </button>';

                        if ($users->is_vip == 1) {
                            $btn .= '<span class="btn btn-sm btn-primary-gradient">حساب VIP</span>';
                        }
                        return $btn;
                    }
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.users.index');
        }
    }

    public function delete($request)
    {

        User::where('id', $request->id)->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

    public function changeStatusUser($request)
    {
        $user = User::findOrFail($request->id);

        ($user->status == 1) ? $user->status = 0 : $user->status = 1;

        $user->save();

        if ($user->status == 1) {
            self::sendFcm('اشعار من الادمن','تم تفعيل حسابك',$user->id);
            return response()->json('200');
        } else {
            self::sendFcm('اشعار من الادمن','تم ايقاف حسابك قم بالاتصال بالدعم',$user->id);
            return response()->json('201');
        }
    }
}
