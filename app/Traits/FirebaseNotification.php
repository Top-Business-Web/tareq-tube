<?php

namespace App\Traits;

use App\Models\DeviceToken;
use App\Models\Notification;
use App\Models\User;

trait FirebaseNotification
{

    //firebase server key
    private string $serverKey = 'AAAADSJHJPw:APA91bEmJEJKIHb30TxM4jXpB-sRsfe3iMvBcv4mhuY2plRkh-iLGtyK-ISk1-7FpCWtzbi761TQmd_PpZJ1sXUz8_Ovhz3JD9e1QdSzeIQZdGW5R3b9daJ5Q2C4tQleH0rgv--iwzl0';


    public function sendFirebaseNotification($data, $user_id = null, $created = false,$interest_id = null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        if ($user_id != null) {
            $userIds = User::where('id', '=', $user_id)->pluck('id')->toArray();
            $tokens = DeviceToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        } else {
            if ($interest_id != null) {
                $userIds = User::where('intrest_id',$interest_id)->pluck('id')->toArray();
            }else {
                $userIds = User::pluck('id')->toArray();
            }
            $tokens = DeviceToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        }

        if (!$created) {
            //|> start notification store
            $createNotification = new Notification();
            $createNotification->title = $data['title'];
            $createNotification->description = $data['body'];
            $createNotification->user_id = $user_id ?? null;
            $createNotification->save();
        }

        $fields = array(
            'registration_ids' => $tokens,
            'data' => ["note_type" => "notification"],
            'notification' => $data
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
