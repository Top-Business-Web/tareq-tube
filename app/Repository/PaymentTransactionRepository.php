<?php

namespace App\Repository;

use App\Interfaces\PaymentTransactionInterface;
use App\Models\PaymentTransaction;
use App\Models\Tube;
use Yajra\DataTables\DataTables;

class PaymentTransactionRepository implements PaymentTransactionInterface
{
    public function index($request)
    {
        if ($request->ajax()) {
            $payment_transaction = PaymentTransaction::get();
            return DataTables::of($payment_transaction)
                ->addColumn('action', function ($payment_transaction) {
                    return '
                            <a href="' . route('payment-transaction.delete', $payment_transaction->id) . '" class="btn btn-pill btn-danger-light">
                                    <i class="fas fa-trash"></i>
                            </a>
                       ';
                })
                ->editColumn('user_id', function ($payment_transaction) {
                    return $payment_transaction->user->name;
                })
                ->editColumn('payment_id', function ($payment_transaction) {
                    return $payment_transaction->payment->transaction_id;
                })
                ->editColumn('status', function ($payment_transaction) {
                    $buttonStyle = $payment_transaction->status == 0 ? 'background-color: #4CAF50; color: #ffffff;' : 'background-color: #FF5252; color: #ffffff;';
                    return '<button style="' . $buttonStyle . 'padding: 10px 20px; border: none; cursor: pointer; font-size: 16px;">' . ($payment_transaction->status == 0 ? 'تم الدفع' : 'لم يتم الدفع') . '</button>';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('admin/payment_transactions/index');
        }
    }

    public function delete($request)
    {
        $payment_transaction = PaymentTransaction::findOrFail($request->id);

            $payment_transaction->delete();
            toastr()->addSuccess("تم حذف العملية بنجاح");

            return redirect()->back();
    }

}