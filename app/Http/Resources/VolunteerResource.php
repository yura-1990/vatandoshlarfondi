<?php

namespace App\Http\Resources;

use App\Enums\CompatriotTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class VolunteerResource extends JsonResource
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
            'id'=> $this->id,
            'volunteer' => new VolunteerNumberResource(
                $this->compatriotExpert()->whereIn('type', [2, 3])->first()
            )
        ];
    }
}
