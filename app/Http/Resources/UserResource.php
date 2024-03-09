<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $balance = $this->points / Setting::first('point_price')->point_price;
        return [

            'name' => $this->name,
            'image' => $this->image,
            'gmail' => $this->gmail,
            'password' => $this->password,
            'google_id' => $this->google_id,
            'city' =>$this->city,
            'interest' => $this->interest,
            'is_vip' => $this->is_vip,
            'points' => $this->points,
            'balance' => $balance,
            'limit' => $this->limit,
            'msg_limit' => $this->msg_limit,
            'youtube_link' => $this->youtube_link,
            'youtube_name' => $this->youtube_name,
            'youtube_image' => $this->youtube_image,
            'invite_token' => $this->invite_token,
            'access_token' => $this->access_token,
            'channel_name' => $this->channel_name,
            'status'=> $this->status,
            'token' =>  $request->header('Authorization') ??  'Bearer ' .$this->token,
        ]; //end UserResource 26-12-2023
    }
}
