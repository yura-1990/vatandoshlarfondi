<?php

namespace App\Models\Userdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BannerExpertOrVolunteerPage extends Model
{
    use HasFactory;
    protected $table = 'banner_expert_or_volunteer_pages';
    protected $fillable = [
      'image',
        'video',
      'title_uz',
      'title_oz',
      'title_ru',
      'title_en',
      'text_uz',
      'text_oz',
      'text_ru',
      'text_en',
      'type'
    ];

    public function expertOrVolunteerPageType(): BelongsTo
    {
        return $this->belongsTo(ExpertOrVolunteerPageType::class);
    }
}
