<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SightseeingResource extends JsonResource
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
            'title' => $this->title,
            'content_title' => $this->content_title,
            'text' => $this->text,
            'image' => $this->image,
            'thumbnail' => $this->thumbnail,
            'city' => new CityResource($this->city),
        ];
    }
}
