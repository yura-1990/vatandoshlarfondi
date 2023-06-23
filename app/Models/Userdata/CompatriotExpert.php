<?php

namespace App\Models\Userdata;

use App\Enums\CompatriotTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TCG\Voyager\Traits\Translatable;


class CompatriotExpert extends Model
{
    use HasFactory, Translatable;

    protected $table = 'compatriot_experts';
    protected array $translatable = [
        'academic_degree',
        'scientific_title',
        'main_science_directions',
        'topic_of_scientific_article',
        'article_published_journal_name',
        'suggestions',
        'additional_information',
    ];
    protected $fillable = [
        'user_id',
        'user_profile_id',
        'academic_degree',
        'scientific_title',
        'main_science_directions',
        'topic_of_scientific_article',
        'scientific_article_created_at',
        'article_published_journal_name',
        'article_url',
        'article_file',
        'images',
        'suggestions',
        'additional_information',
        'type',
        'status',
        'cv_file',
    ];


    /**
     * Get the type.
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value !== null ? CompatriotTypeEnum::tryFrom($value)->name : null
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userEducation(): HasMany
    {
        return $this->HasMany(UserEducation::class);
    }

    public function userEmploymentInfo(): HasMany
    {
        return $this->hasMany(UserEmploymentInfo::class);
    }

    public function userProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function userVolunteerActivities(): HasMany
    {
        return $this->hasMany(UserVolunteerOrExpertActivity::class, 'compatriot_expert_id');
    }

}
