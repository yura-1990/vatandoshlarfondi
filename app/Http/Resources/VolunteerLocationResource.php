<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerLocationResource extends JsonResource
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
            'name'=>$this->name,
            'users' => VolunteerResource::collection($this->userInternationalProfiles)
        ];
    }
}
