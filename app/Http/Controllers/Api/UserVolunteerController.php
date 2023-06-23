<?php

namespace App\Http\Controllers\Api;

use App\Enums\CompatriotTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserVolunteerRequest;
use App\Http\Resources\UserVolunteerResource;
use App\Http\Resources\VolunteerLocationResource;
use App\Models\Public\Location;
use App\Models\Userdata\BannerExpertOrVolunteerPage;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\ExperVolunteerType;
use App\Models\Userdata\UserVolunteerOrExpertActivity;
use App\OpenApi\Parameters\FilterExpertCityParameters;
use App\OpenApi\Parameters\UserVolunteerActivityParameters;
use App\OpenApi\Parameters\UserVolunteerParameters;
use App\OpenApi\RequestBodies\UserVolunteerActivityRequestBody;
use App\OpenApi\Responses\BannerExpertOrVolunteerResponse;
use App\OpenApi\Responses\CompatriotMenuResponse;
use App\OpenApi\Responses\GetAllExpertResponse;
use App\OpenApi\Responses\UserVolunteerActivityResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('volunteer')]
#[PathItem]
class UserVolunteerController extends Controller
{
    /**
     * Filter Volunteer
     */
    #[Get('/filter-volunteer/{pagination}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: FilterExpertCityParameters::class)]
    #[Response(factory: GetAllExpertResponse::class)]
    public function filterVolunteer($pagination=12): JsonResponse
    {
        $country = request()->query('country') ?? null;
        $city = request()->query('city') ?? null;

        if ($country && $city){
            $compatriotExpert = CompatriotExpert::query()
                ->whereIn('type', [CompatriotTypeEnum::VOLUNTEER->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
                ->withWhereHas('userProfile', fn($query)=>$query
                    ->where('international_location_id', $country)
                    ->where('international_address_id', $city))
                ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                    ->where('type', CompatriotTypeEnum::VOLUNTEER->value))
                ->with(['user', 'userEducation', 'userEmploymentInfo'])
                ->orderByDesc('created_at')
                ->paginate($pagination);

            return $this->success($compatriotExpert);

        } elseif ($country){
            $compatriotExpert = CompatriotExpert::query()
                ->whereIn('type', [CompatriotTypeEnum::VOLUNTEER->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
                ->withWhereHas('userProfile', fn($query)=>$query
                    ->where('international_location_id', $country))
                ->with(['user', 'userEducation', 'userEmploymentInfo' ])
                ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                    ->where('type', CompatriotTypeEnum::VOLUNTEER->value))
                ->orderByDesc('created_at')
                ->paginate($pagination);

            return $this->success($compatriotExpert);
        }

        $compatriotExpert = CompatriotExpert::query()
            ->whereIn('type', [CompatriotTypeEnum::VOLUNTEER->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
            ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                ->where('type', CompatriotTypeEnum::VOLUNTEER->value))
            ->with(['userProfile', 'user', 'userEducation', 'userEmploymentInfo'])
            ->orderBy('created_at')
            ->paginate($pagination);

        return $this->success($compatriotExpert);
    }

    /**
     * Get Volunteer Banner
     */
    #[Get('/get-volunteer-banners')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: BannerExpertOrVolunteerResponse::class)]
    public function volunteerBanner(): JsonResponse
    {
        $banners = BannerExpertOrVolunteerPage::query()->get();

        if ($banners->count()>0){
            return $this->success($banners);
        }

        return $this->error([],'No data');
    }

    /**
     * Experts within city
     */
    #[Get('/get-volunteer-city')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: GetAllExpertResponse::class)]
    public function expertsInCities(): JsonResponse
    {
        $userLocations = VolunteerLocationResource::collection(Location::query()->get());

        if ($userLocations->count()>0){
            return $this->success($userLocations);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     *  get all user volunteers
     */
    #[Get('/get-all/{paginate}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerParameters::class)]
    #[Response(factory: CompatriotMenuResponse::class)]
    public function getAllUserVolunteers($paginate): JsonResponse
    {
        $userVolunteer = UserVolunteerOrExpertActivity::query()
            ->orWhere('type', CompatriotTypeEnum::VOLUNTEER->value)
            ->orWhere('type', CompatriotTypeEnum::EXPERT_VOLUNTEER->value)
            ->paginate($paginate);

        if ($userVolunteer->count()>0){
            return $this->success($userVolunteer);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Insert volunteer`s suggestions
     */
    #[Post('/create')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: UserVolunteerActivityRequestBody::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function createUserVolunteer(UserVolunteerRequest $request): JsonResponse
    {
        $data = $request->validated();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $name = $this->uploadFile($image, 'VolunteerImages');
                $images[] = $name;
            }
        }

        $userId = auth()->id();
        $compatriotId = CompatriotExpert::query()->firstWhere('user_id', $userId);
        if (intval($compatriotId->type) == CompatriotTypeEnum::EXPERT->value || $compatriotId->type == CompatriotTypeEnum::EXPERT->name){
            $compatriotId->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $compatriotId->type = CompatriotTypeEnum::VOLUNTEER->value;
        }

        $compatriotId->update();

        $volunteer = UserVolunteerOrExpertActivity::query()->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'images' => json_encode($images) ?? null,
            'compatriot_expert_id' => $compatriotId->id,
            'type' => CompatriotTypeEnum::VOLUNTEER->value
        ]);

        if ($volunteer) {
            return $this->success(new UserVolunteerResource($volunteer));
        }
        return $this->error([], 'No data', 200);
    }

    /**
     * Get Volunteer user
     */
    #[Get('/show-volunteer-user')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getVolunteerUser(): JsonResponse
    {
        $id = Auth::id();
        $volunteerUser = UserVolunteerOrExpertActivity::query()
            ->where('user_id', $id)
            ->where('type', CompatriotTypeEnum::VOLUNTEER->value)
            ->get();

        if ($volunteerUser) {
            return $this->success(UserVolunteerResource::collection($volunteerUser));
        }

        return $this->error([], 'no data created');
    }

    /**
     * Get Volunteer user by id
     */
    #[Get('/show-volunteer-user/{id}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getVolunteerUserById($id): JsonResponse
    {
        $compatrioteExportWithVolunteers = CompatriotExpert::query()
            ->orWhere('type', CompatriotTypeEnum::VOLUNTEER->value)
            ->orWhere('type', CompatriotTypeEnum::EXPERT_VOLUNTEER->value)
            ->where('user_id', $id)
            ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                ->orWhere('type', CompatriotTypeEnum::VOLUNTEER->value))
            ->get();

        return $this->success($compatrioteExportWithVolunteers);
    }

    /**
     * Get one volunteer
     */
    #[Get('/get-one/{id}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getOneUserVolunteer($id): JsonResponse
    {

        $userVolunteerActivity = UserVolunteerOrExpertActivity::query()
            ->where('type', CompatriotTypeEnum::VOLUNTEER->value)
            ->find($id);

        $userVolunteerActivity->viewers += 1;
        $userVolunteerActivity->save();
        if ($userVolunteerActivity) {
            return $this->success(new UserVolunteerResource($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }

    /**
     * Update volunteer`s suggestions
     */
    #[Post('/update/{userVolunteerActivity}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[RequestBody(factory: UserVolunteerActivityRequestBody::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function updateUserVolunteer(UserVolunteerRequest $request, UserVolunteerOrExpertActivity $userVolunteerActivity): JsonResponse
    {
        $data = $request->validated();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $name = $this->uploadFile($image, 'VolunteerImages');
                $images[] = $name;
            }

            if (count(json_decode($userVolunteerActivity->images))>0){
                foreach (json_decode($userVolunteerActivity->images) as $value){
                    $this->deleteFile($value);
                }
            }
        }

        $userId = auth()->id();
        $compatriotId = CompatriotExpert::query()->where('user_id', $userId)->first();

        if (intval($compatriotId->type) == CompatriotTypeEnum::EXPERT->value || $compatriotId->type == CompatriotTypeEnum::EXPERT->name){
            $compatriotId->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $compatriotId->type = CompatriotTypeEnum::VOLUNTEER->value;
        }

        $compatriotId->update();

        $userVolunteerActivity->title = $data['title'];
        $userVolunteerActivity->description = $data['description'];
        if (count($images)>0){
            $userVolunteerActivity->images = json_encode($images);
        }

        $userVolunteerActivity->save();

        if ($userVolunteerActivity) {
            return $this->success(new UserVolunteerResource($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }


    /**
     * Delete volunteer`s suggestions
     */
    #[Delete('/delete/{userVolunteerActivity}')]
    #[Operation(tags: ['Volunteer'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function deleteUserVolunteer(UserVolunteerOrExpertActivity $userVolunteerActivity): JsonResponse
    {
        if ($userVolunteerActivity->delete()) {
            return $this->success(new UserVolunteerResource($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }

}
