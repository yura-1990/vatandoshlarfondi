<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompatriotExportDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'user'=>$this->user,
            'user_education' => $this->userEducation,
            'user_employment_info' => $this->userEmploymentInfo,
            'user_profile' => $this->userProfile,
            'working_company' => $this->working_company,
            'working_company_location_id' => $this->working_company_location_id,
            'working_position' => $this->working_position,
            'working_start_date' => $this->working_start_date,
            'working_finish_date' => $this->working_finish_date,
            'total_experience' => $this->total_experience,
            'academic_degree' => $this->academic_degree,
            'scientific_title' => $this->scientific_title,
            'main_science_directions' => $this->main_science_directions,
            'topic_of_scientific_article' => $this->topic_of_scientific_article,
            'scientific_article_created_at' => $this->scientific_article_created_at,
            'article_published_journal_name' => $this->article_published_journal_name,
            'article_url' => $this->article_url,
            'article_file' => $this->article_file,
            'user_volunteer_activity' => $this->userVolunteerActivity,
        ];
    }
}
