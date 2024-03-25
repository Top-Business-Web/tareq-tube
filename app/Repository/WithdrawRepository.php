<?php

namespace App\Repository;

use App\Interfaces\WithdrawInterface;
use App\Models\Withdraw;
use App\Traits\FirebaseNotification;
use Yajra\DataTables\DataTables;

class WithdrawRepository implements WithdrawInterface
{
    use FirebaseNotification;
    public function index($request)
    {
        if ($request->ajax()) {
            $withdraws = Withdraw::get();
            return DataTables::of($withdraws)
                ->addColumn('action', function ($withdraws) {
                    if ($withdraws->status == 0) {
                        return '
                            <button class="btn btn-pill btn-success-light">
                            <a href="' . route('withdraw.delete', $withdraws->id) . '">
                                      ارسال المبلغ
                            </a>
                            </button>
                       ';
                    }else {
                        return '
                            <button disabled class="btn btn-pill btn-danger-light">
                                     تم الارسال المبلغ
                            </button>
                       ';
                    }
                })
                ->editColumn('user_id', function ($withdraws) {
                    return $withdraws->user->name;
                })
                ->editColumn('price', function ($withdraws) {
                    return $withdraws->price . 'ج.م';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin.withdraw.index');
        }
    }

    public function deleteWithdraw($request)
    {
        $withdraw = Withdraw::query()->findOrFail($request->id);

        $withdraw->status = 1;
        $withdraw->save();

        //|> send FCM notification
        $fcmData = [
            'title' => 'طلب سحب رصيد',
            'body' => 'تم تحويل الرصيد : ' . $withdraw->price  . ' ج.م ' . 'الي رقم فودافون كاش الخاص بك'
        ];
        $this->sendFirebaseNotification($fcmData,$withdraw->user_id);

        toastr()->addSuccess("تم تغيير الحالة بنجاح");
        return redirect()->back();
    }

}
