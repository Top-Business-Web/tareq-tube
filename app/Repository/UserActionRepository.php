<?php

namespace App\Repository;

use App\Interfaces\UserActionInterface;
use App\Models\UserAction;
use Yajra\DataTables\DataTables;

class UserActionRepository implements UserActionInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $user_actions = UserAction::get();
            return DataTables::of($user_actions)
                ->addColumn('action', function ($user_actions) {
                    return '
                            <a href="' . route('userAction.delete', $user_actions->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('user_id', function ($user_actions) {
                    return $user_actions->user->name;
                })
                ->editColumn('tube_id', function ($user_actions) {
                    // Create a link for the tube_id
                    return '<a href="' . $user_actions->tube->url . '" target="_blank" class="tube-link">' . $user_actions->tube->url . '</a>';
                })
                ->editColumn('status', function ($user_actions) {
                    // Create a button based on the status
                    $buttonStyle = $user_actions->status == 0 ? 'background-color: #4CAF50; color: #ffffff;' : 'background-color: #FF5252; color: #ffffff;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border: none; cursor: pointer; font-size: 16px;">' . ($user_actions->status == 0 ? 'مفعلة' : 'غير مفعلة') . '</button>';
                })
                ->editColumn('type', function ($user_actions) {
                    // Create a button based on the type
                    $buttonStyle = $user_actions->type == 'sub' ? 'background-color: #333333; color: #ffffff; border: 1px solid #333333;' : 'background-color: #ff5555; color: #ffffff; border: 1px solid #ff5555;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">' . ($user_actions->type == 'sub' ? 'Subscribe' : 'View') . '</button>';
                })                
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/user_actions/index');
        }
    }

    public function deleteUserAction($request)
    {
        // Find the admin user by ID
        $user_action = UserAction::findOrFail($request->id);

        // Delete the admin user
        $user_action->delete();

        // Show a sweet alert with a cancel button
        toastr()->addSuccess("تم حذف بنجاح");

        // Redirect back after deletion
        return redirect()->back();
    }

}