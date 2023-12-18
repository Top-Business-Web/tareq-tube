<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'type' => $this->type,
            'trip_type' => $this->trip_type,
            'from_address' => $this->from_address,
            'from_long' => $this->from_long,
            'from_lat' => $this->from_lat,
            'to_address' => $this->to_address,
            'to_long' => $this->to_long,
            'to_lat' => $this->to_lat,
            'time_ride' => $this->time_ride,
            'time_arrive' => $this->time_arrive,
            'distance' => $this->distance,
            'time' => $this->time,
            'price' => $this->price,
            'name' => $this->name,
            'phone' => $this->phone,
            'user' => new UserResource($this->user),
            'driver' => new UserResource($this->driver),
            'created_at' => $this->created_at->format('Y-m-d H:i A'),
            'updated_at' => $this->created_at->format('Y-m-d H:i A'),
        ];
    }
}
