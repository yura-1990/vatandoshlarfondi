<?php

namespace App\Services;

use App\Models\User;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileUserService
{
    public function create($data): Model|Collection|Builder|string|array|null
    {
        DB::beginTransaction();

        try {
            $userProfilee = UserProfile::query()->where('user_id', auth()->id())->first();
            if ($userProfilee){
                $compatriotExpert = CompatriotExpert::query()->where('user_profile_id', $userProfilee->id)->first();
                if ($compatriotExpert){
                    $user = User::query()->find(auth()->id());
                    $user->name = $data['first_name'] . ' ' .  $data['second_name'];
                    $user->avatar = $data['avatar_url'] ?? $user->avatar;
                    $user->save();
                } else {
                    $compatriotExpert = new CompatriotExpert();
                    $compatriotExpert->user_profile_id = $userProfilee->id;
                    $compatriotExpert->user_id = auth()->id();
                    $compatriotExpert->save();
                }
                if ($userProfilee->update($data)){
                    DB::commit();
                    return $userProfilee;
                }
            }

            $userProfile = UserProfile::query()->create([
                'user_id'=> Auth::id(),
                'first_name' => $data['first_name'],
                'second_name' => $data['second_name'],
                'last_name' => $data['last_name'],
                'national_address' => $data['national_address'] ?? null,
                'international_location_id' => $data['international_location_id'] ?? null,
                'international_address_id' => $data['international_address_id'] ?? null,
                'national_id' => $data['national_id'] ?? null,
                'birth_date' => $data['birth_date'] ?? null,
                'gender' => $data['gender'] ?? null,
                'academic_degree' => $data['academic_degree'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'scientific_title' => $data['scientific_title'] ?? null,
                'job_position' => $data['job_position'] ?? null,
                'work_experience' => $data['work_experience'] ?? null,
                'additional_info' => $data['additional_info'] ?? null,
                'achievements' => $data['achievements'] ?? null,
                'family_status' => $data['family_status'] ?? 1,
                'hobbies' => $data['hobbies'] ?? null,
                'interests' => $data['interests'] ?? null,
                'opinions_about_uzbekistan' => $data['opinions_about_uzbekistan'] ?? null,
                'suggestions_and_recommendations' => $data['suggestions_and_recommendations'] ?? null,
                'timezone' => $data['timezone'] ?? null,
                'language' => $data['language'] ?? null,
                'avatar_url' => $data['avatar_url'] ?? 'users/default.png',
                'passport_file' => $data['passport_file'] ?? null,
            ]);

            if ($userProfile){
                $compatriotExpert = new CompatriotExpert();
                $compatriotExpert->user_profile_id = $userProfile->id;
                $compatriotExpert->user_id = auth()->id();
                $compatriotExpert->save();
                $user = User::query()->find(auth()->id());
                $user->name = $data['first_name'] . ' ' .  $data['second_name'];
                $user->avatar = $data['avatar_url'] ?? $user->avatar;
                $user->save();

                DB::commit();

                return $userProfile;
            }

            return 'error 3';

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }


}
