<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEmploymentResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user_profile_id' => $this->user_profile_id,
            'academic_degree' => $this->academic_degree,
            'scientific_title' => $this->scientific_title,
            'main_science_directions' => $this->main_science_directions,
            'topic_of_scientific_article' => $this->topic_of_scientific_article,
            'scientific_article_created_at' => $this->scientific_article_created_at,
            'article_published_journal_name' => $this->article_published_journal_name,
            'article_url' => $this->article_url,
            'article_file' => $this->article_file,
            'images' => $this->images,
            'suggestions' => $this->suggestions,
            'additional_information' => $this->additional_information,
            'verified' => $this->verified,
            'type' => $this->type,
            'status' => $this->status,
            'cv_file' => $this->cv_file,
            'user' => $this->user,
            'user_education' => $this->userEducation,
            'user_employment_info' => UserEmploymentInfoResource::collection($this->userEmploymentInfo),
            'user_profile' => $this->userProfile,
            'user_volunteer_activities' => $this->userVolunteerActivities
        ];
    }
}
