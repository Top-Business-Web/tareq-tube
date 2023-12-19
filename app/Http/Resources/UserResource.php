<?php

namespace App\Http\Resources;

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
            'image' => $this->image,
            'gmail' => $this->gmail,
            'password' => $this->password,
            'google_id' => $this->google_id,
            'city_id' =>$this->city_id,
            'is_admin' => $this->is_admin,
            'intrest_id' => $this->intrest_id,
            'points' => $this->points,
            'limit' => $this->limit,
            'msg_limit' => $this->msg_limit,
            'youtube_link' => $this->youtube_link,
            'token' => 'Bearer ' . $this->token,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
