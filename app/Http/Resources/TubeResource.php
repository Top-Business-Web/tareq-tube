<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TubeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "points" => $this->points,
            'vat_point' => $this->vat_point,
            "url" => $this->url,
            "target" => $this->target,
            "status" => $this->status,
            "sub_count" => $this->subCount,
            "second_count" => $this->secondCount,
            "view_count" => $this->viewCount,
            "user" => new UserResource(\Auth::guard('user-api')->user()),
            "created_at" => ($this->created_at) ? $this->created_at->format('Y-m-d H:i:s') : '',
            "updated_at" => ($this->updated_at) ? $this->updated_at->format('Y-m-d H:i:s') : '',
        ];
    }
}
