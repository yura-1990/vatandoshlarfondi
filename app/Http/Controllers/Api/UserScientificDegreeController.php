<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserScientificDegreeRequest;
use App\Http\Resources\UserScientificDegreeResource;
use App\Models\Userdata\CompatriotExpert;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Parameters\DeleteUserScientificDegreeParameters;
use App\OpenApi\RequestBodies\UserScientificDegreeRequestBody;
use App\OpenApi\Responses\UserScientificDegreeResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
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

#[Prefix('scientificDegree')]
#[PathItem]
class UserScientificDegreeController extends Controller
{
    /**
     * Get all scientific degree info
     */
    #[Get('/all-scientific-degree')]
    #[Operation(tags: ['Expert Scientific Degree'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: UserScientificDegreeResponse::class)]
    public function getAllUserScientificDegree(): JsonResponse
    {
        $data = UserScientificDegreeResource::collection(CompatriotExpert::query()->get());
        return $this->success($data);
    }

    /**
     * @param CreateUserScientificDegreeRequest $request
     * @return JsonResponse
     */
    #[Post('/create')]
    #[Operation(tags: ['Expert Scientific Degree'],security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: UserScientificDegreeRequestBody::class)]
    #[Response(factory: UserScientificDegreeResponse::class)]
    public function createUserScientificDegree(CreateUserScientificDegreeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user_id = auth()->id();

        $oneScientificDegree = CompatriotExpert::query()->where('user_id', $user_id)->first();

        if ($request->hasFile('article_file')) {
            if ($this->deleteFile($oneScientificDegree->article_file)){
                $data['article_file'] = $this->uploadFile($request->file('article_file'), 'articles');
            }
        }

        $scientificDegree = CompatriotExpert::query()->updateOrCreate(
            [
                'user_id' => $user_id,
            ],
            [
                'academic_degree' => $data['academic_degree'],
                'scientific_title' => $data['scientific_title'],
                'main_science_directions' => $data['main_science_directions'],
                'topic_of_scientific_article' => $data['topic_of_scientific_article'],
                'scientific_article_created_at' => $data['scientific_article_created_at'],
                'article_published_journal_name' => $data['article_published_journal_name'],
                'article_file' => $data['article_file'] ?? $oneScientificDegree->article_file,
                'article_url' => $data['article_url'],
            ]
        );

        if ($scientificDegree){
            return $this->success(new UserScientificDegreeResource($scientificDegree));
        }

        return $this->error([], 'error');
    }

    /**
     * Get User Employment Info
     */
    #[Get('/show-scientific-degree')]
    #[Operation(tags: ['Expert Scientific Degree'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: UserScientificDegreeResponse::class)]
    public function showUserScientificDegree(): JsonResponse
    {
        $id =  auth()->id();
        $userScientificDegree = CompatriotExpert::query()->where('user_id', $id)->get();

        if ($userScientificDegree){
            return $this->success(UserScientificDegreeResource::collection($userScientificDegree));
        }

        return $this->error([], 'no data');
    }

    /**
     * delete User Scientific Degree
     */
    #[Delete('/delete/{compatriotExpert}')]
    #[Operation(tags: ['Expert Scientific Degree'], security: BearerTokenSecurityScheme::class, method: 'DELETE')]
    #[Parameters(factory: DeleteUserScientificDegreeParameters::class)]
    #[Response(factory: UserScientificDegreeResponse::class)]
    public function deleteUserScientificDegree(CompatriotExpert $compatriotExpert): JsonResponse
    {
        if ($compatriotExpert->article_file){
            $this->deleteFile($compatriotExpert->article_file);
        }
        $compatriotExpert->academic_degree = null;
        $compatriotExpert->scientific_title = null;
        $compatriotExpert->main_science_directions = null;
        $compatriotExpert->scientific_article_created_at = null;
        $compatriotExpert->topic_of_scientific_article = null;
        $compatriotExpert->article_published_journal_name = null;
        $compatriotExpert->article_file = null;
        $compatriotExpert->article_url = null;
        $compatriotExpert->save();

        return $this->success(new UserScientificDegreeResource($compatriotExpert));
    }

}
