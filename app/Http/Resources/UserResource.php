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
        return [

            'name' => $this->name,
            'image' => asset('storage/'.$this->image),
            'gmail' => $this->gmail,
            'password' => $this->password,
            'google_id' => $this->google_id,
            'city' =>$this->city,
            'interest' => $this->interest,
            'points' => $this->points,
            'balance' => $this->points / Setting::first('point_price')->point_price,
            'limit' => $this->limit,
            'msg_limit' => $this->msg_limit,
            'youtube_link' => $this->youtube_link,
            'token' =>  $request->header('Authorization') ??  'Bearer ' .$this->token,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->created_at->format('Y-m-d H:i:s'),
        ]; // end
    }
}
