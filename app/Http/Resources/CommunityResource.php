<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
            'logo' => $this->logo,
            'document' => $this->document,
            'director' => $this->director,
            'director_img' => $this->director_img,
            'work' => $this->work,
            'created_date' => $this->created_date,
            'members' => $this->members,
            'achievement' => $this->achievement,
            'region_id' => $this->region_id,
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'site' => $this->site,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'region_name' => $this->region_name,
            'city_name' => $this->city_name,
            'b_title' => $this->b_title,
            'b_description' => $this->b_description,
            'b_image' => $this->b_image,
            'attachments' => $this->attachments->pluck('path'),
        ];

    }
}
