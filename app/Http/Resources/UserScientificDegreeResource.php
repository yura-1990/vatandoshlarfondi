<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class UserScientificDegreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'academic_degree'=>$this->academic_degree,
            'scientific_title'=>$this->scientific_title,
            'topic_of_scientific_article'=>$this->topic_of_scientific_article,
            'article_published_journal_name'=>$this->article_published_journal_name,
            'scientific_article_created_at'=>$this->scientific_article_created_at,
            'article_url' => $this->article_url,
            'article_file'=> $this->article_file,
            'main_science_directions'=>$this->main_science_directions,
        ];
    }
}
