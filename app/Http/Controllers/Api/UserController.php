<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\Userdata\UserProfile;
use App\OpenApi\RequestBodies\RegisterRequestBody;
use App\OpenApi\Responses\DeleteAvatarResponse;
use App\OpenApi\Responses\RegisterResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\ProfileUserService;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('auth')]
#[PathItem]
class UserController extends Controller
{
    /**
     * register a user
     */
    #[Post('register')]
    #[Operation(tags: ['Auth'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: RegisterRequestBody::class)]
    #[Response(factory: RegisterResponse::class)]
    public function register(CreateUserRequest $request, ProfileUserService $service): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('avatar_url')) {
            $data['avatar_url'] = $this->uploadFile($request->file('avatar_url'), 'avatar');
        }

        if ($request->hasFile('passport_file')) {
            $data['passport_file'] = $this->uploadFile($request->file('passport_file'), 'passport');
        }

        $model = $service->create($data);

        if ($model) {
            return $this->success($model);
        }

        return $this->error([], 'No data', 404);
    }

    /**
     * @return JsonResponse
     */
    #[Get('/delete/avatar')]
    #[Operation(tags: ['Auth'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: DeleteAvatarResponse::class)]
    public function deleteAvatar(): JsonResponse
    {
        $user = UserProfile::query()->firstWhere('user_id', auth()->id());

        if ($user->count() > 0){
            if ($user->avatar_url){
                if ($user->avatar_url != 'users/default.png'){
                    if ($this->deleteFile($user->avatar_url)){
                        $user->avatar_url = '';
                        $user->save();
                        return $this->success(['message'=>'file deleted successfully']);
                    }
                    return $this->error([], 'no avatar in this user');
                }
                return $this->error([], 'Something went wrong');
            }
            return $this->error([], 'no avatar in this user');
        }

        return $this->error([], 'no avatar in this user');
    }
    /**
     * @return JsonResponse
     */
    #[Get('/getme')]
    #[Operation(tags: ['Auth'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getMe(): JsonResponse
    {
        return $this->success(['user'=>auth('api')->user()]);
    }
}
