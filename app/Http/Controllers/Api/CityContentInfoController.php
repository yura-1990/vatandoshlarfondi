<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUzbekistan\CityContentInfo;
use App\OpenApi\Responses\CityContentInfoResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('city-content')]
#[PathItem]
class CityContentInfoController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['City'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: CityContentInfoResponse::class)]
    public function getAllCityContentInfo(Request $request): JsonResponse
    {
        $language = $request->header('language');

        $cityContentInfo = CityContentInfo::query()->get();

        foreach ($cityContentInfo as &$content){
            $content->title = $content->getTranslatedAttribute('title', $language);
            $content->title = $content->getTranslatedAttribute('content', $language);
            unset($content);
        }

        if ($cityContentInfo->count()>0){
            return $this->success($cityContentInfo);
        }

        return $this->error([], 'No data');
    }
}
