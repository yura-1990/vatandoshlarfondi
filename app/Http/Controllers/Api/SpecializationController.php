<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Userdata\Specialization;
use App\OpenApi\Responses\SpecializationResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('specialization')]
#[PathItem]
class SpecializationController extends Controller
{
    /**
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['Specialization'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: SpecializationResponse::class)]
    public function getAllSpecialization(): JsonResponse
    {
        $specialization = Specialization::query()->get();
        if ($specialization){
            return $this->success($specialization);
        }
        return $this->error([], 'No data');
    }
}
