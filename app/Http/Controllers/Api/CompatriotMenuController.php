<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Userdata\CompatriotMenu;
use App\OpenApi\Parameters\CompatriotMenuParameters;
use App\OpenApi\Responses\CompatriotMenuResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('menu')]
#[PathItem]
class CompatriotMenuController extends Controller
{
    /**
     * Get all menus
     */
    #[Get('/all')]
    #[Operation(tags: ['ExpertsMenu'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: CompatriotMenuResponse::class)]
    public function getAllMenu(): JsonResponse
    {
        $data = CompatriotMenu::query()->get();

        if (count($data) > 0) {
            return $this->success($data);
        }

        return $this->error([], 'No data', 404);
    }

    /**
     * Get one menu
     */
    #[Get('/single/{id}')]
    #[Operation(tags: ['ExpertsMenu'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CompatriotMenuParameters::class)]
    #[Response(factory: CompatriotMenuResponse::class)]
    public function getSingleMenu($id): JsonResponse
    {
        $data = CompatriotMenu::query()->find($id);

        if ($data) {
            return $this->success($data);
        }

        return $this->error([], 'No data', 404);
    }

    /**
     * Get one menu by user_id
     */
    #[Get('/user')]
    #[Operation(tags: ['ExpertsMenu'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: CompatriotMenuResponse::class)]
    public function getMenuByUser(): JsonResponse
    {
        $id = intval(Auth::id());
        $data = CompatriotMenu::query()->firstWhere('user_id', $id);

        if ($data) {
            return $this->success($id);
        }

        return $this->error([], 'No data', 404);
    }

}
