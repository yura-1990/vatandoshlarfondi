<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityVideoResource;
use App\Models\AboutUzbekistan\CityVideo;
use App\OpenApi\Parameters\CityVideoParameters;
use App\OpenApi\Parameters\CityVideosParameters;
use App\OpenApi\Responses\CityVideoResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('city-video')]
#[PathItem]
class CityVideoController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['City Video'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CityVideosParameters::class)]
    #[Response(factory: CityVideoResponse::class)]
    public function getAllCityVideo(Request $request): JsonResponse
    {
        $language = $request->header('language');
        $paginate = $request->get('paginate');

        if ($paginate){
            $cityVideos = CityVideo::query()->paginate($paginate);
        } else {
            $cityVideos = CityVideo::query()->get();
        }

        foreach ($cityVideos as &$cityVideo){
            $cityVideo->title = $cityVideo->getTranslatedAttribute('title', $language);
            $cityVideo->content = $cityVideo->getTranslatedAttribute('content', $language);

            unset($cityVideo->translations);
        }

        if ($cityVideos){
            return $this->success($cityVideos);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * @param Request $request
     * @param CityVideo $cityVideo
     * @return JsonResponse
     */
    #[Get('/get-one/{cityVideo}')]
    #[Operation(tags: ['City Video'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CityVideoParameters::class)]
    #[Response(factory: CityVideoResponse::class)]
    public function getOneCityVideo(Request $request, CityVideo $cityVideo): JsonResponse
    {
        $language = $request->header('language');

        $cityVideo->title = $cityVideo->getTranslatedAttribute('title', $language);
        $cityVideo->content = $cityVideo->getTranslatedAttribute('content', $language);
        unset($cityVideo->translations);

        if ($cityVideo->count()>0){
            return $this->success($cityVideo);
        }

        return $this->error([], 'No data');
    }
}
