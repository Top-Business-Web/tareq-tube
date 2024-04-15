<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyTubeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        if($this->type == 'sub'){
            $target = ($this->subCount->count -  $this->target) .'/'. $this->subCount->count;
        }elseif($this->type == 'view') {
            $target = ($this->viewCount->count - $this->target) .'/'. $this->viewCount->count;
        }else {
            $target = ($this->appCount->count - $this->target) .'/'. $this->appCount->count;
        }
        return [
            "id" => $this->id,
            "type" => $this->type,
            "url" => $this->url,
            "target" => $target,
            "status" => $this->status,
            "created_at" => $this->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
