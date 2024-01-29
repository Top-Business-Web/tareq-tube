<?php

namespace App\Repository\Api\User;

use App\Interfaces\Api\User\PaymentRepositoryInterface;
use App\Models\ModelPrice;
use App\Models\Package;
use App\Models\PackageUser;
use App\Models\Payment;
use App\Models\User;
use App\Repository\Api\ResponseApi;
use App\Traits\FirebaseNotification;
use App\Traits\PhotoTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayMob\Facades\PayMob;

class PaymentRepository extends ResponseApi implements PaymentRepositoryInterface
{
    use PhotoTrait, FirebaseNotification;

    /**
     * @param Request $request
     */
    public function goPay(Request $request)
    {
        // handle payment requests
        $model_id = $request->model_id;
        $model_type = $request->model_type;
        $amount = $request->amount;
        $user = Auth::user();

        $newPayment = new Payment();
        $newPayment->type = $model_type;
        $newPayment->price = $amount;
        $newPayment->user_id = $user->id;
        $newPayment->model_id = $model_id;
        $newPayment->save();

        $data = [
            'model_id' => $model_id,
            'model_type' => $model_type,
            'amount' => $amount,
            'order_id' => $newPayment->id
        ];

        return $this->pay($data);

    } // goPay

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function pay(array $data): JsonResponse
    {
        $order_id = $data['order_id'];
        $total_price = $data['amount'];

        $auth = PayMob::AuthenticationRequest();

        $order = PayMob::OrderRegistrationAPI([
            'auth_token' => $auth->token,
            'amount_cents' => $total_price * 100, //put your price
            'currency' => 'EGP',
            'delivery_needed' => false, // another option true
            'merchant_order_id' => $order_id,
            'items' => [] // create all items information or leave it empty
        ]);

        $PaymentKey = PayMob::PaymentKeyRequest([
            'auth_token' => $auth->token,
            'amount_cents' => $total_price * 100, //put your price
            'currency' => 'EGP',
            'order_id' => $order->id,
            "billing_data" => [ // put your client information
                "apartment" => "803",
                "email" => "claudette09@exa.com",
                "floor" => "42",
                "first_name" => "Clifford",
                "last_name" => "Nicolas",
                "street" => "Ethan Land",
                "building" => "8028",
                "phone_number" => "+86(8)9135210487",
                "shipping_method" => "PKG",
                "postal_code" => "01898",
                "city" => "Jaskolskiburgh",
                "country" => "EG",
                "state" => "Cairo"
            ]
        ]);

        $url = "https://accept.paymobsolutions.com/api/acceptance/iframes/817230?payment_token=" . $PaymentKey->token;

        return self::returnResponseDataApi(['payment_url' => $url], "تم استلام لينك الدفع بنجاح ", 200);

    } // pay

    /**
     * @param Request $request
     */
    public function callback(Request $request)
    {
        $data = [
            'status' => $request['success'],
            'id' => $request['id'],
            'order_id' => $request['merchant_order_id'],
            'payment_type' => $request['source_data_sub_type']
        ];
        if ($data['status'] == 'false') {
            return $this->checkout($data);
        }else {
            return self::returnResponseDataApi(['status'=>0],'عملية دفع فاشلة اتصل بالدعم',422);
        }
    } // call callback

    /**
     * @param array $data
     */
    public function checkout(array $data)
    {
        $order = Payment::find($data['order_id']);

        $order->transaction_id = $data['transaction_id'];
        $order->save();
        $user = User::find($order->user_id);
        if ($order->type == 'model') {
            $model = ModelPrice::query()->find($order->model_id);
            if ($model->type == 'msg'){
                $model->count;
                $user->msg_limit += $model->count;
                $user->save();

                return self::returnResponseDataApi(['status'=>1],'عملية شراء رسائل ناجحة');
            }else {
                $model->count;
                $user->points += $model->count;
                $user->limit += $model->count;
                $user->save();
                return self::returnResponseDataApi(['status'=>1],'عملية شراء نقاط ناجحة');
            }

        } elseif ($order->type == 'package') {
            // declare package variables
            $model = Package::query()->find($order->model_id);
            $days = $model->days;
            $current_time = Carbon::now();
            $end_time = Carbon::now()->addDays($days);

            // create package user
            $createPackageUser = new PackageUser();
            $createPackageUser->package_id = $model->id;
            $createPackageUser->user_id  = $user->id;
            $createPackageUser->from = $current_time;
            $createPackageUser->to = $end_time;
            $createPackageUser->save();

            // Update user
            $user->is_vip = 1;
            $user->save();

            return self::returnResponseDataApi(['status'=>1],'عملية شراء باقة VIP ناجحة');

        } else {
            return self::returnResponseDataApi(['status'=>0],'عملية دفع فاشلة اتصل بالدعم',422);
        }
    } // checkout data
}
