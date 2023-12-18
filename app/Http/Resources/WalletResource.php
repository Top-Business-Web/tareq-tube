<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vat_total' => $this->vat_total,
            'trips' => TripWalletResource::collection($this->trips),
            'driver' => new UserResource($this->driver),
        ];
    }
}
