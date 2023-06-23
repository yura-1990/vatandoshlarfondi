<?php

namespace App\Models\Userdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpertOrVolunteerPageType extends Model
{
    use HasFactory;
    protected $table = 'expert_or_volunteer_page_types';
    protected $fillable = ['type'];

    public function bannerExpertOrVolunteerPages(): HasMany
    {
        return $this->hasMany(BannerExpertOrVolunteerPage::class, 'type');
    }
}
