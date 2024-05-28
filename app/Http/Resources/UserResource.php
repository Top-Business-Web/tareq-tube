<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $balance = $this->points / Setting::first('point_price')->point_price;
        $lucky_box_config = Setting::first()->value('config_box_minute');
        if ($this->box_open_time > Carbon::now()->addMinutes($lucky_box_config)->format('Y-m-d H:i:s')) {
            $lucky_box_status = 1;
        }else {
            $lucky_box_status = 0;
        }
         if ($this->open_ad_time > Carbon::now() !== null) {

             $next_open_time= Carbon::parse($this->box_open_time) ->addMinutes($lucky_box_config)->format('Y-m-d H:i:s');


         }







             return [

            'name' => $this->name,
            'image' => $this->image,
            'gmail' => $this->gmail,
            'password' => $this->password,
            'google_id' => $this->google_id,
            'city' => $this->city,
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
            'status' => $this->status,
            'box_open_time' => $this->box_open_time,
            'next_open_time' => $next_open_time ?? null,

            'open_ad_time' => $this->open_ad_time,
            'reward_box_open' => $this->reward_box_open,
            'reward_box_id' => $this->reward_box_id,
            'reward_box_status' => $this->reward_box_open == Carbon::now()->format('Y-m-d') ? 1 : 0,
            'lucky_box_status' => $lucky_box_status,
            'token' => $request->header('Authorization') ?? 'Bearer ' . $this->token,
        ]; //end UserResource 26-12-2023
    }
}
