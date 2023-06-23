<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUzbekistan\City3D;
use App\OpenApi\Parameters\City3DParameters;
use App\OpenApi\Responses\City3DResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('city3d')]
#[PathItem]
class City3DController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['City 3D'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: City3DResponse::class)]
    public function getAllCity3D(): JsonResponse
    {
        $city3D = City3D::query()->get();

        if ($city3D->count()>0){
            return $this->success($city3D);
        }

        return $this->error([], 'No data');
    }

    /**
     * @param City3D $city3D
     * @return JsonResponse
     */
    #[Get('/get-one/{city3D}')]
    #[Operation(tags: ['City 3D'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: City3DParameters::class)]
    #[Response(factory: City3DResponse::class)]
    public function getOneCity3D(City3D $city3D): JsonResponse
    {
        if ($city3D){
            return $this->success($city3D);
        }

        return $this->error([], 'No data');
    }
}
