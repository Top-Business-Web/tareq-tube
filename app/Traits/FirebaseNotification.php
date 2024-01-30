<?php

namespace App\Traits;

use App\Models\DeviceToken;
use App\Models\Notification;
use App\Models\User;

trait FirebaseNotification
{

    //firebase server key
    private string $serverKey = 'AAAAgU3S_qk:APA91bFM8J_dvNalQDGUDdoLZQnxtAyscbw3ZLE4CYJ1l5ofbpOIFiaUK0qsDvZP0dOFlrytnlOjS7Bfxk3PcoaesXY8alRAkGQyAmQO-BteeovaJ3k2sOlHB2acOEtFktLFKdMmo8bV';


    public function sendFirebaseNotification($data, $user_id = null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        if ($user_id != null) {
            $userIds = User::where('id', '=', $user_id)->pluck('id')->toArray();
            $tokens = DeviceToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        } else {
            $userIds = User::pluck('id')->toArray();
            $tokens = DeviceToken::whereIn('user_id', $userIds)->pluck('token')->toArray();
        }


        //start notification store
        Notification::query()
            ->create([
                'title' => $data['title'],
                'description' => $data['body'],
                'user_id' => $user_id ?? null,
            ]);

        $fields = array(
            // 'registration_ids' => $tokens,
            'registration_ids' => [
                'ctHo9fMpQTGLXrP1JnkrJR:APA91bHRFT15MXQSa8225BpcSUGGvWDy92rYGAYYglAj9dLaV8WhdDcBjhZCse4azycfsfIZcftB42D04Oy6hAN_Qg6AfcK0CZbgEdWnayRgTKtuddbfKgL5AMnPK9Hd0G-TFW60z2Dv'
            ],
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