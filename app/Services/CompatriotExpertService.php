<?php

namespace App\Services;

use App\Models\Userdata\CompatriotExpert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CompatriotExpertService
{
    public function create($data): Model|Builder
    {
        return CompatriotExpert::query()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'institution' => $data['institution'],
                'institution_location_id' => $data['institution_location_id'],
                'faculty' => $data['faculty'],
                'specialization' => $data['specialization'],
                'working_company' => $data['working_company'],
                'working_company_location_id' => $data['working_company_location_id'],
                'working_position' => $data['working_position'],
                'working_start_date' => $data['working_start_date'],
                'working_finish_date' => $data['working_finish_date'],
                'total_experience' => $data['total_experience'],
                'academic_degree' => $data['academic_degree'],
                'scientific_title' => $data['scientific_title'],
                'main_science_directions' => $data['main_science_directions'],
                'topic_of_scientific_article' => $data['topic_of_scientific_article'],
                'scientific_article_created_at' => $data['scientific_article_created_at'],
                'article_published_journal_name' => $data['article_published_journal_name'],
                'article_url' => $data['article_url'],
                'article_file' => $data['article_file'],
                'suggestions' => $data['suggestions'],
                'cv_file' => storage_path($data['cv_file']) ?? null,
                'additional_information' => $data['additional_information']
            ]
        );

    }
}
