<?php

namespace App\Http\Controllers\Api;

use App\Enums\CompatriotTypeEnum;
use App\Facades\CountFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserVolunteerRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UserEmploymentInfoResource;
use App\Http\Resources\UserEmploymentResource;
use App\Http\Resources\UserVolunteerResource;
use App\Models\Public\Location;
use App\Models\Userdata\BannerExpertOrVolunteerPage;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserProfile;
use App\Models\Userdata\UserVolunteerOrExpertActivity;
use App\OpenApi\Parameters\FilterExpertParameters;
use App\OpenApi\Parameters\GetSingleExpertParameters;
use App\OpenApi\Parameters\PaginateExpertsParameters;
use App\OpenApi\Parameters\UserVolunteerActivityParameters;
use App\OpenApi\RequestBodies\UserVolunteerActivityRequestBody;
use App\OpenApi\Responses\BannerExpertOrVolunteerResponse;
use App\OpenApi\Responses\GetAllExpertResponse;
use App\OpenApi\Responses\RegisterResponse;
use App\OpenApi\Responses\UserVolunteerActivityResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\CountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

#[Prefix('expert')]
#[PathItem]
class CompatriotExpertController extends Controller
{
    /**
     * Filter Expert
     */
    #[Get('/filter-expert/{pagination}')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: FilterExpertParameters::class)]
    #[Response(factory: GetAllExpertResponse::class)]
    public function filterExpert($pagination=12): JsonResponse
    {
        $country = request()->query('country') ?? null;
        $specialization = request()->query('specialization') ?? null;

        if ($country && $specialization){

            $compatriotExpert = CompatriotExpert::query()
                ->whereIn('type', [CompatriotTypeEnum::EXPERT->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
                ->withWhereHas('userProfile', function($query) use($country){
                    return $query->where('international_location_id', $country);
                })
                ->withWhereHas('userEducation', function($query) use($specialization){
                    return $query->where('specialization_id', $specialization);
                })
                ->withWhereHas('userVolunteerActivities', function($query){
                    return $query->where('type', CompatriotTypeEnum::EXPERT->value);
                })
                ->with(['user', 'userEmploymentInfo'])
                ->orderByDesc('created_at')
                ->paginate($pagination);

            foreach ($compatriotExpert as $value){
                foreach ($value->userEmploymentInfo as $item ){
                    $item->experience = CountService::countExperiences($item->start_date, $item->finish_date);
                }
            }

            return $this->success($compatriotExpert);

        }
        elseif ($country){
            $compatriotExpert = CompatriotExpert::query()
                ->whereIn('type', [CompatriotTypeEnum::EXPERT->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
                ->withWhereHas('userProfile', function($query) use($country){
                    return $query->where('international_location_id', $country);
                })
                ->with(['user', 'userEducation', 'userEmploymentInfo'])
                ->withWhereHas('userVolunteerActivities', function($query){
                    return $query->where('type', CompatriotTypeEnum::EXPERT->value);
                })
                ->orderByDesc('created_at')
                ->paginate($pagination);

            foreach ($compatriotExpert as $value){
                foreach ($value->userEmploymentInfo as $item ){
                    $item->experience = CountService::countExperiences($item->start_date, $item->finish_date);
                }
            }

            return $this->success($compatriotExpert);

        }
        elseif($specialization){
            $compatriotExpert = CompatriotExpert::query()
                ->whereIn('type', [CompatriotTypeEnum::EXPERT->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
                ->withWhereHas('userEducation', function($query) use($specialization){
                    return $query->where('specialization_id', $specialization);
                })
                ->withWhereHas('userVolunteerActivities', function($query){
                    return $query->where('type', CompatriotTypeEnum::EXPERT->value);
                })
                ->with(['user', 'userProfile', 'userEmploymentInfo'])
                ->orderByDesc('created_at')
                ->paginate($pagination);

            foreach ($compatriotExpert as $value){
                foreach ($value->userEmploymentInfo as $item ){
                    $item->experience = CountService::countExperiences($item->start_date, $item->finish_date);
                }
            }

            return $this->success($compatriotExpert);

        }

        $compatriotExpert = CompatriotExpert::query()
            ->whereIn('type', [CompatriotTypeEnum::EXPERT->value, CompatriotTypeEnum::EXPERT_VOLUNTEER->value])
            ->withWhereHas('userVolunteerActivities', function($query){
                return $query->where('type', CompatriotTypeEnum::EXPERT->value);
            })
            ->with(['user', 'userProfile', 'userEducation', 'userEmploymentInfo'])
            ->paginate($pagination);

        foreach ($compatriotExpert as $value){
            foreach ($value->userEmploymentInfo as $item ){
                $item->experience = CountService::countExperiences($item->start_date, $item->finish_date);
            }
        }

        return $this->success($compatriotExpert);
    }

    /**
     * Get Expert Banner
     */
    #[Get('/get-expert-banners')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: BannerExpertOrVolunteerResponse::class)]
    public function expertBanner(): JsonResponse
    {
        $banners = BannerExpertOrVolunteerPage::query()->get();

        if ($banners->count()>0){
            return $this->success($banners);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Experts within city
     */
    #[Get('/get-expert-city')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: GetAllExpertResponse::class)]
    public function expertsInCities(): JsonResponse
    {
        $userLocations = LocationResource::collection(Location::query()->get());

        if ($userLocations->count()>0){
            return $this->success($userLocations);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Get all experts
     */
    #[Get('/get-all/{paginate}')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: PaginateExpertsParameters::class)]
    #[Response(factory: GetAllExpertResponse::class)]
    public function getAllExperts(Request $request, $paginate): JsonResponse
    {
        $experts = CompatriotExpert::query()
            ->orWhere('type', CompatriotTypeEnum::EXPERT->value)
            ->orWhere('type', CompatriotTypeEnum::EXPERT_VOLUNTEER->value)
            ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                ->orWhere('type', CompatriotTypeEnum::EXPERT->value)
            )
            ->paginate($paginate);
        if ($experts->count() > 0) {
            return $this->success($experts);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Get single expert
     */
    #[Get('/get-single/{id}')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: GetSingleExpertParameters::class)]
    #[Response(factory: GetAllExpertResponse::class)]
    public function getSingleExpert($id): JsonResponse
    {
        $singleExpert = CompatriotExpert::query()
            ->withWhereHas('userVolunteerActivities', fn($query)=>$query
                ->orWhere('type', CompatriotTypeEnum::EXPERT->value)
            )
            ->find($id);

        if ($singleExpert) {
            return $this->success(new UserEmploymentResource($singleExpert));
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Get auth user data
     */
    #[Get('/registered-user-data')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: RegisterResponse::class)]
    public function registeredUserDataForCompatriotExpert(): JsonResponse
    {
        $userProfile = UserProfile::query()
            ->firstWhere('user_id', auth()->id());



        if ($userProfile){
            return $this->success($userProfile);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * Get Expert user by id
     */
    #[Get('/show-expert-user/{id}')]
    #[Operation(tags: ['Experts'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getExpertUserById($id): JsonResponse
    {
        $compatrioteExportWithVolunteers = CompatriotExpert::query()
            ->orWhere('type', CompatriotTypeEnum::EXPERT->value)
            ->orWhere('type', CompatriotTypeEnum::EXPERT_VOLUNTEER->value)
            ->where('user_id', $id)
            ->get();

        return $this->success($compatrioteExportWithVolunteers);
    }

    /* <>=<>=<>=<>=<>=<><<<<< Expert activity >>>><>=<>=<>=<>=<>=<> */

    /**
     * Insert experts` activity
     */
    #[Post('/activity/create')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: UserVolunteerActivityRequestBody::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function createUserExpert(UserVolunteerRequest $request): JsonResponse
    {
        $data = $request->validated();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $name = $this->uploadFile($image, 'ExpertImages');
                $images[] = $name;
            }
        }

        $userId = auth()->id();
        $compatriotId = CompatriotExpert::query()->firstWhere('user_id', $userId);
        if (
            intval($compatriotId->type) == CompatriotTypeEnum::VOLUNTEER->value
            || intval($compatriotId->type) == CompatriotTypeEnum::EXPERT_VOLUNTEER->value
            || $compatriotId->type == CompatriotTypeEnum::VOLUNTEER->name
            || $compatriotId->type == CompatriotTypeEnum::EXPERT_VOLUNTEER->name
        ){
            $compatriotId->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $compatriotId->type = CompatriotTypeEnum::EXPERT->value;
        }

        $compatriotId->save();

        $expert = UserVolunteerOrExpertActivity::query()->create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'images' => json_encode($images) ?? null,
            'compatriot_expert_id' => $compatriotId->id,
            'type' => CompatriotTypeEnum::EXPERT->value
        ]);

        if ($expert) {
            return $this->success(new UserVolunteerResource($expert));
        }
        return $this->error([], 'No data', 200);
    }

    /**
     * Get expert user
     */
    #[Get('/show-expert-user')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getExpertUser(): JsonResponse
    {
        $id = Auth::id();
        $volunteerUser = UserVolunteerOrExpertActivity::query()
            ->where('user_id', $id)
            ->where('type', CompatriotTypeEnum::EXPERT->value)
            ->get();

        if ($volunteerUser) {
            return $this->success(UserVolunteerResource::collection($volunteerUser));
        }

        return $this->error([], 'no data created');
    }

    /**
     * Get one expert
     */
    #[Get('/get-one/{id}')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getOneUserExpert($id): JsonResponse
    {
        $userVolunteerActivity = UserVolunteerOrExpertActivity::query()
            ->where('type', CompatriotTypeEnum::EXPERT->value)
            ->find($id);
        if ($userVolunteerActivity) {
            return $this->success(new UserVolunteerResource($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }

    /**
     * Get one expert
     */
    #[Get('/user-expert-activity/{id}')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function getUserExpert($id): JsonResponse
    {
        $userVolunteerActivity = UserVolunteerOrExpertActivity::query()
            ->where('type', CompatriotTypeEnum::EXPERT->value)
            ->where('user_id', $id)->get();
        if ($userVolunteerActivity) {
            return $this->success(UserVolunteerResource::collection($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }

    /**
     * Update experts` suggestions
     */
    #[Post('/update/{userVolunteerActivity}')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[RequestBody(factory: UserVolunteerActivityRequestBody::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function updateUserExpert(UserVolunteerRequest $request, UserVolunteerOrExpertActivity $userVolunteerActivity): JsonResponse
    {
        $data = $request->validated();
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image){
                $name = $this->uploadFile($image, 'expertImages');
                $images[] = $name;
            }
        }

        $userId = auth()->id();
        $compatriotId = CompatriotExpert::query()->where('user_id', $userId)->first();
        if (intval($compatriotId->type) == CompatriotTypeEnum::VOLUNTEER->value || $compatriotId->type == CompatriotTypeEnum::VOLUNTEER->name){
            $compatriotId->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $compatriotId->type = CompatriotTypeEnum::EXPERT->value;
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
     * Delete experts` suggestions
     */
    #[Delete('/delete/{userVolunteerActivity}')]
    #[Operation(tags: ['Expert activity'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: UserVolunteerActivityParameters::class)]
    #[Response(factory: UserVolunteerActivityResponse::class)]
    public function deleteUserExpert(UserVolunteerOrExpertActivity $userVolunteerActivity): JsonResponse
    {
        if ($userVolunteerActivity->delete()) {
            return $this->success(new UserVolunteerResource($userVolunteerActivity));
        }
        return $this->error([], 'no data created');
    }


}
