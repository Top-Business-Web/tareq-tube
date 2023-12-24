<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'id' => $this->id,
            'about_ar' => $this->about_ar,
            'about_en' => $this->about_en,
            'terms_ar' => $this->terms_ar,
            'terms_en' => $this->terms_en,
            'phones' => $this->phones,
            'email' => $this->email,
            'instagram' => $this->instagram,
            'whatsapp' => $this->whatsapp,
            'facebook' => $this->facebook,
            'youtube' => $this->twitter,
        ];
    }
}
