<?php

namespace App\Http\Controllers\Api;

use App\Enums\CompatriotTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExpertSuggestionRequest;
use App\Http\Requests\CreateUserEmploymentInfoRequest;
use App\Http\Requests\UpdateExpertSuggestionRequest;
use App\Http\Resources\ExpertSuggestionResource;
use App\Http\Resources\UserEmploymentInfoResource;
use App\Http\Resources\UserScientificDegreeResource;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserEmploymentInfo;
use App\OpenApi\Parameters\AllExpertSuggestionParameters;
use App\OpenApi\Parameters\DeleteUserScientificDegreeParameters;
use App\OpenApi\RequestBodies\CreateExpertSuggestionRequestBody;
use App\OpenApi\RequestBodies\CreateUserEmploymentInfoRequestBody;
use App\OpenApi\Responses\AllExpertSuggestionResponse;
use App\OpenApi\Responses\AllUserEmploymentInfoResponse;
use App\OpenApi\Responses\UserScientificDegreeResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

#[Prefix('suggestion')]
#[PathItem]
class CompatriotExpertSuggestionController extends Controller
{
    /**
     * Get User suggestion Info
     */
    #[Get('/all-or-one-expert-suggestion')]
    #[Operation(tags: ['Expert Suggestion'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: AllExpertSuggestionParameters::class)]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function allUserScientificDegree(Request $request): JsonResponse
    {
        $paginate = $request->query('paginate') ?? null;
        $one = $request->query('id') ?? null;

        if ($one){
            $expertSuggestion = CompatriotExpert::query()
                ->where('verified', true)
                ->with('userProfile')
                ->find($one);
            if ($expertSuggestion){
                return $this->success($expertSuggestion);
            }
        }
        if ($paginate){
            $expertSuggestion = CompatriotExpert::query()
                ->where('verified', true)
                ->with('userProfile')
                ->paginate($paginate);
            return $this->success($expertSuggestion);
        }

        $expertSuggestion = CompatriotExpert::query()
            ->with('userProfile')
            ->where('verified', true)
            ->get();

        return $this->success($expertSuggestion);
    }

    /**
     * Insert experts` suggestions
     */
    #[Post('/create')]
    #[Operation(tags: ['Expert Suggestion'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: CreateExpertSuggestionRequestBody::class)]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function createUserEmploymentInfo(CreateExpertSuggestionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $images = [];

        $expertSuggestionImage = CompatriotExpert::query()
            ->where('user_id', auth()->id())
            ->first();

        if ($request->hasFile('images')) {

            if ($expertSuggestionImage->images ){
                if (count(json_decode($expertSuggestionImage->images)) > 0 ){
                    foreach (json_decode($expertSuggestionImage->images) as $image){
                        $this->deleteFile($image);
                    }
                }
            }

            foreach ($request->file('images') as $image){
                $name = $this->uploadFile($image, 'expertSuggestion');
                $images[] = $name;
            }
        }

        $expertSuggestion = CompatriotExpert::query()
            ->where('user_id', auth()->id())
            ->first();

        if (intval($expertSuggestion->type) == CompatriotTypeEnum::VOLUNTEER->value || $expertSuggestion->type == CompatriotTypeEnum::VOLUNTEER->name){
            $expertSuggestion->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $expertSuggestion->type = CompatriotTypeEnum::EXPERT->value;
        }
        $expertSuggestion->suggestions = $data['suggestions'];
        $expertSuggestion->additional_information = $data['additional_information'];
        if (count($images)>0){
            $expertSuggestion->images = json_encode($images);
        }
        $expertSuggestion->verified = false;

        $expertSuggestion->update();

        if ($expertSuggestion) {
            return $this->success(new ExpertSuggestionResource($expertSuggestion));
        }
        return $this->error([], 'no data created');
    }

    /**
     * Get User Employment Info
     */
    #[Get('/show-expert-suggestion')]
    #[Operation(tags: ['Expert Suggestion'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function showUserScientificDegree(): JsonResponse
    {
        $id = auth()->id();
        $expertSuggestion = CompatriotExpert::query()->where('user_id', $id)->get();

        if ($expertSuggestion){
            return $this->success(ExpertSuggestionResource::collection($expertSuggestion));
        }

        return $this->error([], 'no data');
    }

    /**
     * Update experts` suggestions
     */
    #[Post('/update/{compatriotExpert}')]
    #[Operation(tags: ['Expert Suggestion'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[Parameters(factory: DeleteUserScientificDegreeParameters::class)]
    #[RequestBody(factory: CreateExpertSuggestionRequestBody::class)]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function updateUserEmploymentInfo(UpdateExpertSuggestionRequest $request, CompatriotExpert $compatriotExpert): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'expertSuggestion');
            $this->deleteFile($compatriotExpert->image);
        }

        $compatriotExpert->suggestions = $data['suggestions'];
        $compatriotExpert->additional_information = $data['additional_information'];
        $compatriotExpert->image = $data['image'];
        $compatriotExpert->verified = false;

        if (intval($compatriotExpert->type) == CompatriotTypeEnum::VOLUNTEER->value || $compatriotExpert->type == CompatriotTypeEnum::VOLUNTEER->name){
            $compatriotExpert->type = CompatriotTypeEnum::EXPERT_VOLUNTEER->value;
        } else {
            $compatriotExpert->type = CompatriotTypeEnum::EXPERT->value;
        }

        $compatriotExpert->update();

        if ($compatriotExpert){
            return $this->success(new ExpertSuggestionResource($compatriotExpert));
        }


        return $this->error([], 'no data created');
    }

    /**
     * delete Expert Suggestion
     */
    #[Delete('/delete/{compatriotExpert}')]
    #[Operation(tags: ['Expert Suggestion'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: DeleteUserScientificDegreeParameters::class)]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function deleteUserScientificDegree(CompatriotExpert $compatriotExpert): JsonResponse
    {
            if ($compatriotExpert->count() > 0){
                if ($compatriotExpert->image){
                    $this->deleteFile($compatriotExpert->image);
                }
                $compatriotExpert->suggestions = null;
                $compatriotExpert->additional_information = null;
                $compatriotExpert->image = null;
                $compatriotExpert->verified = false;
                $compatriotExpert->save();
                return $this->success(new ExpertSuggestionResource($compatriotExpert));
            }
        return $this->error([], 'Failed');
    }

}
