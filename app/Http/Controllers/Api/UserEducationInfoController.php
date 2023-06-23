<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserEducationInfoRequest;
use App\Http\Requests\UpdateUserEducationInfoRequest;
use App\Http\Resources\UserEducationInfo;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserEducation;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Parameters\ShowOneUserEducationParameters;
use App\OpenApi\Parameters\UserEducationInfoParameters;
use App\OpenApi\RequestBodies\CreateUserEducationInfoRequestBody;
use App\OpenApi\RequestBodies\UpdateUserEducationInfoRequestBody;
use App\OpenApi\Responses\CreateUserEducationInfoResponse;
use App\OpenApi\Responses\UpdateUserEducationInfoResponse;
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

#[Prefix('education')]
#[PathItem]
class UserEducationInfoController extends Controller
{
    /**
     * Get All User Education
     */
    #[Get('/all-user-education')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: CreateUserEducationInfoResponse::class)]
    public function getAllUserEducation(): JsonResponse
    {
        $userEducation = UserEducation::query()->get();

        if ($userEducation) {
            return $this->success(UserEducationInfo::collection($userEducation));
        }

        return $this->error([], 'no data created', 200);
    }

    /**
     * Create user education
     */
    #[Post('/create')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: CreateUserEducationInfoRequestBody::class)]
    #[Response(factory: CreateUserEducationInfoResponse::class)]
    public function createUserEducation(CreateUserEducationInfoRequest $request): JsonResponse
    {
        $data = $request->validated();

        $userProfileId = UserProfile::query()->where('user_id', auth()->id())->first();
        $compatriotExpertUserID = CompatriotExpert::query()->where('user_profile_id', $userProfileId->id)->first();
        $userEducation = [];
        foreach ($data['expert'] as $item) {
            $userEducation[] = UserEducation::query()->create([
                'user_id' => Auth::id(),
                'institution' => $item['institution'],
                'level' => $item['level'],
                'faculty' => $item['faculty'],
                'specialization_id' => $item['specialization_id'],
                'type' => $item['type'],
                'compatriot_expert_id' => $compatriotExpertUserID->id
            ]);
        }

        if ($userEducation) {
            return $this->success(UserEducationInfo::collection($userEducation));
        }

        return $this->error([], 'no data created', 200);
    }

    /**
     * Get User Education
     */
    #[Get('/show-user')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: CreateUserEducationInfoResponse::class)]
    public function getUserEducation(): JsonResponse
    {
        $id = Auth::id();
        $userEducation = UserEducation::query()->where('user_id', $id)->get();

        if ($userEducation) {
            return $this->success(UserEducationInfo::collection($userEducation));
        }

        return $this->error([], 'no data created', 200);
    }

    /**
     * Get User Education
     */
    #[Get('/show-one-user/{user_id}')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ShowOneUserEducationParameters::class)]
    #[Response(factory: CreateUserEducationInfoResponse::class)]
    public function getOneUserEducationById($user_id): JsonResponse
    {
        $userEducation = UserEducation::query()->where('user_id', $user_id)->get();

        if ($userEducation) {
            return $this->success(UserEducationInfo::collection($userEducation));
        }

        return $this->error([], 'no data created', 200);
    }


    /**
     * Update user education
     */
    #[Patch('/update/{userEducation}')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'PATCH')]
    #[Parameters(factory: UserEducationInfoParameters::class)]
    #[RequestBody(factory: UpdateUserEducationInfoRequestBody::class)]
    #[Response(factory: UpdateUserEducationInfoResponse::class)]
    public function updateUserEducation(UpdateUserEducationInfoRequest $request, UserEducation $userEducation): JsonResponse
    {
        $data = $request->validated();
        $userProfileId = UserProfile::query()->where('user_id', auth()->id())->first();
        $compatriotExpertUserID = CompatriotExpert::query()->where('user_profile_id', $userProfileId->id)->first();

        $userEducation->institution = $data['institution'];
        $userEducation->level = $data['level'];
        $userEducation->faculty = $data['faculty'];
        $userEducation->specialization_id = $data['specialization_id'];
        $userEducation->type = $data['type'];
        $userEducation->compatriot_expert_id = $compatriotExpertUserID->id;
        $userEducation->save();

        return $this->success(new UserEducationInfo($userEducation));

    }

    /**
     * Update user education
     */
    #[Delete('/delete/{userEducation}')]
    #[Operation(tags: ['Expert Education'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: UserEducationInfoParameters::class)]
    #[Response(factory: UpdateUserEducationInfoResponse::class)]
    public function deleteUserEducation(UserEducation $userEducation): JsonResponse
    {
        if ($userEducation) {
            $userEducation->delete();
            return $this->success(new UserEducationInfo($userEducation));
        }

        return $this->error([], 'no data created', 200);
    }
}
