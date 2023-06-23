<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Public\Location;
use App\Models\Public\National;
use App\OpenApi\Responses\GetAllLocationResponse;
use App\OpenApi\Responses\GetAllNationaliesResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('/national')]
#[PathItem]
class NationalController extends Controller
{
    /**
     * get all national
     */
    #[Get('/get-all')]
    #[Operation(tags: ['National'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: GetAllNationaliesResponse::class)]
    public function getAllLocation(): JsonResponse
    {
        return $this->success(National::all());
    }


}
