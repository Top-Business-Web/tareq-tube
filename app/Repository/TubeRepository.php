<?php

namespace App\Repository;

use App\Interfaces\TubeInterface;
use App\Models\Tube;
use Yajra\DataTables\DataTables;

class TubeRepository implements TubeInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $tubes = Tube::get();
            return DataTables::of($tubes)
                ->addColumn('action', function ($tubes) {
                    return '
                    <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                        data-id="' . $tubes->id . '" data-title="' . $tubes->url . '">
                        <i class="fas fa-trash"></i>
                    </button>
                       ';
                })
                ->editColumn('user_id', function ($tubes) {
                    return $tubes->user->name;
                })
                ->editColumn('type', function ($tubes) {
                    // Create a button based on the type
                    $buttonStyle = $tubes->type == 'sub' ? 'background-color: #333333; color: #ffffff; border: 1px solid #333333;' : 'background-color: #ff5555; color: #ffffff; border: 1px solid #ff5555;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px;">' . ($tubes->type == 'sub' ? 'Subscribe' : 'View') . '</button>';
                })
                ->editColumn('url', function ($tubes) {
                    return '<a href="' . $tubes->url . '" target="_blank" style="background-color: #007bff; color: #fff; padding: 5px; cursor: pointer; text-decoration: none; border: 1px solid #007bff; border-radius: 5px;">' . $tubes->url . '</a>';
                })
                ->editColumn('status', function ($tubes) {
                    // Create a button based on the status
                    $buttonStyle = $tubes->status == 0 ? 'background-color: #4CAF50; color: #ffffff;' : 'background-color: #FF5252; color: #ffffff;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border: none; cursor: pointer; font-size: 16px;">' . ($tubes->status == 0 ? 'مفعلة' : 'غير مفعلة') . '</button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/tubes/index');
        }
    }

    public function deleteTube($request)
    {
        $tube = Tube::findOrFail($request->id);

            $tube->delete();
            return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }

}