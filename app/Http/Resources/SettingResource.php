<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'trip_insurance' => $this->trip_insurance,
            'rewards' => $this->rewards,
            'about' => $this->about,
            'support' => $this->support,
            'safety_roles' => $this->safety_roles,
            'polices' => $this->polices,
            'km' => $this->km,
            'vat' => $this->vat,
        ];
    }
}
