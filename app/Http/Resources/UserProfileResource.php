<?php

namespace App\Http\Resources;

use App\Enums\CompatriotTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'id'=>$this->id,
            'expert' => new VolunteerNumberResource(
                $this->compatriotExpert()->whereIn('type', [1, 3])->first()
            )
        ];
    }
}
