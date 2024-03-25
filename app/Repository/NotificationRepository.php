<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Notification;
use App\Repository\Api\ResponseApi;
use Yajra\DataTables\DataTables;
use App\Interfaces\NotificationInterface;

class NotificationRepository extends ResponseApi implements NotificationInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $notifications = Notification::get();
            return DataTables::of($notifications)
                ->addColumn('action', function ($notifications) {
                    return '
                    <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                    data-id="' . $notifications->id . '" data-title="' . $notifications->title . '">
                    <i class="fas fa-trash"></i>
            </button>
                       ';
                })
                ->editColumn('user_id', function ($notifications) {
                    return $notifications->user->name ?? 'كل المستخدمين';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/notifications/index');
        }
    }

    public function showCreate()
    {
         $users = User::query()->select('id', 'gmail')->get();
         return view('admin/notifications/parts/create', compact('users'));
    }

    public function storeNotification($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createNotification($inputs)) {
                //|> send FCM notification
                self::sendFcm($inputs['title'],$inputs['description'],$inputs['user_id'] ?? null,true);
                toastr()->addSuccess('تم اضافة الاشعار بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createNotification($inputs)
    {
        return Notification::create($inputs);
    }

//    public function showEditNotification($id)
//    {
//        $notification = Notification::findOrFail($id);
//
//        $users = User::query()->select('id', 'name')->get();
//        $notificationData = $notification->only(['id', 'title', 'description', 'user_id']);
//
//        return view('admin/notifications/parts/edit', compact('notificationData', 'users'));
//    }

//    public function updateNotification($request, $id)
//    {
//        try {
//            $notification = Notification::findOrFail($id);
//
//            $inputs = $request->except('id');
//
//            $notification->update($inputs);
//
//            toastr()->addSuccess('تم التعديل الاشعار بنجاح');
//            return redirect()->back();
//        } catch (\Exception $e) {
//            toastr()->addError('هناك خطأ: ' . $e->getMessage());
//        }
//
//        return redirect()->back();
//    }

    public function deleteNotification($request)
    {
        $notification = Notification::findOrFail($request->id);

        $notification->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    } // delete notifications

}
