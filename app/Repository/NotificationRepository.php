<?php

namespace App\Repository;

use App\Models\User;
use App\Models\Notification;
use Yajra\DataTables\DataTables;
use App\Traits\FirebaseNotification;
use App\Interfaces\NotificationInterface;

class NotificationRepository implements NotificationInterface
{

    use FirebaseNotification;
    
    public function index($request)
    {
        if ($request->ajax()) {
            $notifications = Notification::get();
            return DataTables::of($notifications)
                ->addColumn('action', function ($notifications) {
                    return '
                            <a href="' . route('notification.edit', $notifications->id) . '" class="btn btn-pill btn-info-light"><i class="fa fa-edit"></i></a>
                            <a href="' . route('notification.delete', $notifications->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('user_id', function($notifications) {
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
        return $this->sendFirebaseNotification([
            'title' => 'ffff',
            'body' => 'ffff',
        ], 1);
        // $users = User::query()->select('id', 'name')->get();
        // return view('admin/notifications/parts/create', compact('users'));
    }

    public function storeNotification($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createNotification($inputs)) {
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

    public function showEditNotification($id)
    {
        $notification = Notification::findOrFail($id);

        $users = User::query()->select('id', 'name')->get();
        $notificationData = $notification->only(['id', 'title', 'description', 'user_id']);

        return view('admin/notifications/parts/edit', compact('notificationData', 'users'));
    }

    public function updateNotification($request, $id)
    {
        try {
            $notification = Notification::findOrFail($id);

            $inputs = $request->except('id');

            $notification->update($inputs);

            toastr()->addSuccess('تم التعديل الاشعار بنجاح');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->addError('هناك خطأ: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function deleteNotification($request)
    {
        $notification = Notification::findOrFail($request->id);

            $notification->delete();
            toastr()->addSuccess("تم حذف الاشعار بنجاح");
            return redirect()->back();
    }

}