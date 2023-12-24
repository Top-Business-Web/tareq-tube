<?php

namespace App\Repository;

use App\Models\Message;
use Yajra\DataTables\DataTables;
use App\Interfaces\MessageInterface;

class MessageRepository implements MessageInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $messages = Message::get();
            return DataTables::of($messages)
                ->addColumn('action', function ($messages) {
                    return '
                            <a href="' . route('message.delete', $messages->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('url', function ($messages) {
                    return '<a href="' . $messages->url . '" target="_blank" style="background-color: #007bff; color: #fff; padding: 5px; cursor: pointer; text-decoration: none; border: 1px solid #007bff; border-radius: 5px;">' . $messages->url . '</a>';
                })
                ->editColumn('user_id', function($messages) {
                    return $messages->user->name;
                })
                ->editColumn('city_id', function($messages) {
                    return $messages->city->name;
                })
                ->editColumn('intrest_id', function($messages) {
                    return $messages->intrest->name;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/messages/index');
        }
    }

    public function deleteMessage($request)
    {
        $message = Message::findOrFail($request->id);

            $message->delete();
            toastr()->addSuccess("تم حذف الرسالة بنجاح");
            return redirect()->back();
    }

}