<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use PayMob\Facades\PayMob;

class PaymentController extends Controller
{
    // Payment Integration
    public static function pay(float $total_price, int $order_id)
    {

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
                "street" => "Ethan Land",
                "building" => "8028",
                "phone_number" => "+86(8)9135210487",
                "shipping_method" => "PKG",
                "postal_code" => "01898",
                "city" => "Jaskolskiburgh",
                "country" => "CR",
                "last_name" => "Nicolas",
                "state" => "Utah"
            ]
        ]);

        return $PaymentKey->token;


    }

    ################## الرد في حاله نجاح عمليه الدفع الالكتروني او فشل عمليه الدفع #########
    public function checkout_processed(Request $request)
    {

        $request_hmac = $request->hmac;
        $calc_hmac = PayMob::calcHMAC($request);

        if ($request_hmac == $calc_hmac) {

            $order_id = $request->obj['order']['merchant_order_id'];
            $amount_cents = $request->obj['amount_cents'];
            $transaction_id = $request->obj['id'];

            $order = Payment::find($order_id);

            if ($request->obj['success'] == true && ($order->total_price * 100) == $amount_cents) {

                $order->update([
                    'transaction_status' => 'finished',
                    'transaction_id' => $transaction_id
                ]);

                $userSubscribes = UserSubscribe::query()
                    ->where('student_id', '=', $order->user_id)
                    ->get();

                $array = [];

                foreach ($userSubscribes as $userSubscribe) {

                    $array[] = $userSubscribe->month < 10 ? "0" . $userSubscribe->month : "$userSubscribe->month";
                }

                $studentAuth = User::find($order->user_id);
                $studentAuth->subscription_months_groups = json_encode($array);
                $studentAuth->save();

            } else {
                $order->update([
                    'transaction_status' => "failed",
                    'transaction_id' => $transaction_id
                ]);


            }
        }
    }

    ############################# التوجهه بعد عمليه الدفع الالكتروني ################
    public function responseStatus(Request $request): RedirectResponse
    {
        return redirect()->to('api/checkout?status=' . $request['success'] . '&id=' . $request['id']);
    }


    public function checkout(Request $request)
    {
        if ($request->status) {

            return response()->json(array('success' =>true));

        } else {

            return response()->json(array('success' =>false));

        }
    }
} // Payment Controller
