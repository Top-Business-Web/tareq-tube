<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\PhoneToken;
use App\Models\User;

trait FirebaseNotification
{

    //firebase server key
    private string $serverKey = 'AAAAYR8Sg9c:APA91bG2iz-PO2r1Pt7D-Z6BCBlKsfslMYDx7bTkoiXYC9Fvd8hCs-7rV82Qec5gpJyoR6AZQUsuDXJJiuLFXmqFhXrDijyJQR7TGU-ZzE---BcLvvp46AMvVJikSFjdaP0XIYM33klH';


    public function sendFirebaseNotification($data, $user_id = null, $type = 'user', $create = true)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';

        if ($user_id != null && $type == 'user') {
            $userIds = User::where('id', '=', $user_id)->pluck('id')->toArray();
            $tokens = PhoneToken::whereIn('user_id', $userIds)->pluck('token')->toArray();

        } elseif ($user_id != null && $type == 'driver') {
            $userIds = User::where('id', '=', $user_id)->pluck('id')->toArray();
            $tokens = PhoneToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        } elseif ($user_id == null && $type == 'all_user') {
            $usersIds = User::where('type', '=', 'user')->pluck('id')->toArray();
            $tokens = PhoneToken::whereIn('user_id', $usersIds)->pluck('token')->toArray();
        } elseif ($user_id == null && $type == 'all_driver') {
            $usersIds = User::where('type', '=', 'driver')
                ->where('status', '=', true)->pluck('id')->toArray();
            $tokens = PhoneToken::whereIn('user_id', $usersIds)->pluck('token')->toArray();
        } else {
            $userIds = User::pluck('id')->toArray();
            $tokens = PhoneToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        }

        if ($create === true) {
            //start notification store
            Notification::query()
                ->create([
                    'title' => $data['title'],
                    'description' => $data['body'],
                    'user_id' => $user_id ?? null,
                    'type' => $type
                ]);
        }

        $fields = array(
            'registration_ids' => $tokens,
            'data' => $data,
        );
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

}
