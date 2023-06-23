<?php

namespace App\Http\Resources;

use App\Enums\CompatriotTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVolunteerResource extends JsonResource
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
            'id' => $this->id,
            'user_id'=>$this->user_id,
            'title' => $this->title,
            'description'=>$this->description,
            'images' => json_decode($this->images),
            'compatriot_expert_id'=>$this->compatriot_expert_id,
            'type' => CompatriotTypeEnum::from($this->type)->name,
            'verified' => $this->verified,
            'viewers' => $this->viewers,
            'created_at' => $this->created_at,
        ];
    }
}
