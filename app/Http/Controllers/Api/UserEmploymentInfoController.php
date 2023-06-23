<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserEmploymentInfoRequest;
use App\Http\Requests\UpdateUserEmploymentInfoRequest;
use App\Http\Resources\UserEmploymentInfoResource;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserEmploymentInfo;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Parameters\ShowOneUserEmploymentParameters;
use App\OpenApi\Parameters\UserEmploymentInfoParameters;
use App\OpenApi\RequestBodies\CreateUserEmploymentInfoRequestBody;
use App\OpenApi\RequestBodies\UpdateUserEmploymentInfoRequestBody;
use App\OpenApi\Responses\AllUserEmploymentInfoResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Patch;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('employment')]
#[PathItem]
class UserEmploymentInfoController extends Controller
{
    /**
     * Get all employment info
     */
    #[Get('/all-employment')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function getAllUserEmploymentInfo(): JsonResponse
    {
        return $this->success(UserEmploymentInfoResource::collection(UserEmploymentInfo::all()));
    }

    /**
     * create a new data for user employment
     */
    #[Post('/create')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class,)]
    #[RequestBody(factory: CreateUserEmploymentInfoRequestBody::class)]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function createUserEmploymentInfo(CreateUserEmploymentInfoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userProfileId = UserProfile::query()->where('user_id', auth()->id())->first()->id;
        $compatriotExpertUserID = CompatriotExpert::query()->where('user_profile_id', $userProfileId)->first();
        $userEmployment = [];
        foreach ($data['expert'] as $employment) {
            $userEmployment[] = UserEmploymentInfo::query()->create([
                'user_id' => auth()->id(),
                'company' => $employment['company'],
                'position' => $employment['position'],
                'location_id' => $employment['location_id'],
                'status' => $employment['status'],
                'city' => $employment['city'],
                'start_date' => $employment['start_date'],
                'finish_date' => $employment['finish_date'],
                'specialization' => $employment['specialization'],
                'compatriot_expert_id'=>$compatriotExpertUserID->id
            ]);
        }

        if ($data) {
            return $this->success(UserEmploymentInfoResource::collection($userEmployment));
        }
        return $this->error([], 'no data created');
    }

    /**
     * Get User Employment Info
     */
    #[Get('/show-user')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function getUserEmploymentInfo(): JsonResponse
    {
        $id = Auth::id();
        $userEmployment = UserEmploymentInfo::query()->where('user_id', $id)->get();

        if ($userEmployment) {
            return $this->success(UserEmploymentInfoResource::collection($userEmployment));
        }

        return $this->error([], 'no data created');
    }

    /**
     * Get User Employment Info
     */
    #[Get('/show-one-user/{user_id}')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ShowOneUserEmploymentParameters::class)]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function getOneUserEmploymentInfoById($user_id): JsonResponse
    {
        $userEmployment = UserEmploymentInfo::query()->where('user_id', $user_id)->get();

        if ($userEmployment) {
            return $this->success(UserEmploymentInfoResource::collection($userEmployment));
        }

        return $this->error([], 'no data created');
    }

    /**
     * Update User Employment Info
     */
    #[Patch('/update/{userEmploymentInfo}')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class, method: 'PATCH')]
    #[Parameters(factory: UserEmploymentInfoParameters::class)]
    #[RequestBody(factory: UpdateUserEmploymentInfoRequestBody::class)]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function updateUserEmployment(UpdateUserEmploymentInfoRequest $request, UserEmploymentInfo $userEmploymentInfo): JsonResponse
    {
        $data = $request->validated();

        $userProfileId = UserProfile::query()->where('user_id', auth()->id())->first()->id;
        $compatriotExpertUserID = CompatriotExpert::query()->where('user_profile_id', $userProfileId)->first();

        $userEmploymentInfo->company = $data['company'];
        $userEmploymentInfo->position = $data['position'];
        $userEmploymentInfo->location_id = $data['location_id'];
        $userEmploymentInfo->city = $data['city'];
        $userEmploymentInfo->start_date = $data['start_date'];
        $userEmploymentInfo->finish_date = $data['finish_date'];
        $userEmploymentInfo->specialization = $data['specialization'];
        $userEmploymentInfo->compatriot_expert_id = $compatriotExpertUserID->id;
        $userEmploymentInfo->save();

        return $this->success(new UserEmploymentInfoResource($userEmploymentInfo));

    }

    /**
     * Delete User Employment Info
     */
    #[Delete('/delete/{userEmploymentInfo}')]
    #[Operation(tags: ['Expert Employment'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: UserEmploymentInfoParameters::class)]
    #[Response(factory: AllUserEmploymentInfoResponse::class)]
    public function deleteUserEmployment(UserEmploymentInfo $userEmploymentInfo): JsonResponse
    {
        if ($userEmploymentInfo->delete()) {
            return $this->success(new UserEmploymentInfoResource($userEmploymentInfo));
        }

        return $this->error([], 'Failed');
    }
}
