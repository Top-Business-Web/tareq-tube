<?php

namespace App\Http\Resources;

use App\Models\DriverDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverDocumentResource extends JsonResource
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
            'agency_number' => asset($this->agency_number),
            'bike_license' => asset($this->bike_license),
            'id_card' => asset($this->id_card),
            'house_card' => asset($this->house_card),
            'bike_image' => asset($this->bike_image),
            'status' => $this->status,
            'driver_details' => new DriverResource($this->driver),
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
