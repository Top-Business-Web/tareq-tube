<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationInterface $notificationInterface;

    public function __construct(NotificationInterface $notificationInterface)
    {
        $this->notificationInterface = $notificationInterface;
    }

    public function index(Request $request)
    {
        return $this->notificationInterface->index($request);
    }

    public function showCreate(Request $request)
    {
        return $this->notificationInterface->showCreate($request);
    }

    public function storeNotification(Request $request)
    {
        return $this->notificationInterface->storeNotification($request);
    }

//    public function showEditNotification($id)
//    {
//        return $this->notificationInterface->showEditNotification($id);
//    }
//
//    public function updateNotification(Request $request, $id)
//    {
//        return $this->notificationInterface->updateNotification($request, $id);
//    }

    public function deleteNotification(Request $request)
    {
        return $this->notificationInterface->deleteNotification($request);
    }
}
