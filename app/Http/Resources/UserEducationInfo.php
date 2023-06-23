<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEducationInfo extends JsonResource
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
            'institution' => $this->institution,
            'level' => $this->level,
            'faculty' => $this->faculty,
            'specialization' => $this->specialization,
            'type' => $this->type
        ];
    }
}
