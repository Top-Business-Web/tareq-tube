<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [

            'id' => $this->id,
            'bike_type' => $this->bike_type,
            'bike_model' => $this->bike_model,
            'bike_color' => $this->bike_color,
            'area' =>  new AreaResource($this->area),
            'driver' => new UserResource($this->driver),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
