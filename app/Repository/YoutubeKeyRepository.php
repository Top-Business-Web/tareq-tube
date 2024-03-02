<?php

namespace App\Repository;

use App\Interfaces\YoutubeKeyInterface;
use App\Models\YoutubeKey;
use Yajra\DataTables\DataTables;

class YoutubeKeyRepository implements YoutubeKeyInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $keys = YoutubeKey::get();
            return DataTables::of($keys)
                ->addColumn('action', function ($keys) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                        data-id="' . $keys->id . '" data-title="' . $keys->name . '">
                                        <i class="fas fa-trash"></i>
                                </button>
                       ';
                })
                ->editColumn('limit',function($keys){
                    $limitCalc = 10000 - $keys->limit;
                    $keys->limit >= 9900 ? $limitCalc = 0 : $limitCalc;
                    return $limitCalc;
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/youtube_key/index');
        }
    }

    public function showCreate()
    {
        return view('admin/youtube_key/parts/create');
    }

    public function storeKey($request)
    {
        try {
            $inputs = $request->all();

            if ($this->createKey($inputs)) {
                toastr()->addSuccess('تم اضافة Key بنجاح');
                return redirect()->back();
            } else {
                toastr()->addError('هناك خطأ ما');
            }
        } catch (\Exception $e) {
            toastr()->addError('حدث خطأ: ' . $e->getMessage());
        }
    }

    private function createKey($inputs)
    {
        return YoutubeKey::create($inputs);
    }

    public function deleteKey($request)
    {
        $interest = YoutubeKey::findOrFail($request->id);

        $interest->delete();
        return response(['message' => 'تم الحذف بنجاح', 'status' => 200], 200);
    }
}
