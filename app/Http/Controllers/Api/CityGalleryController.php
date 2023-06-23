<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUzbekistan\CityGallery;
use App\OpenApi\Parameters\CityGalleriesParameters;
use App\OpenApi\Parameters\CityGalleryParameters;
use App\OpenApi\Responses\CityGalleryResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('photo-gallery')]
#[PathItem]
class CityGalleryController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['City Gallery'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CityGalleriesParameters::class)]
    #[Response(factory: CityGalleryResponse::class)]
    public function getAllCityPhotoGallery(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $paginate = $request->query('paginate');

        if ($paginate){
            $cityGalleries = CityGallery::query()->paginate($paginate);
        } else {
            $cityGalleries = CityGallery::query()->get();
        }

        foreach ($cityGalleries as &$cityGallery){
            $cityGallery->title = $cityGallery->getTranslatedAttribute('title', $language);

            unset($cityGallery->translations);
        }

        if ($cityGalleries){
            return $this->success($cityGalleries);
        }

        return $this->error([], 'No data');
    }

    /**
     * Get one city galleries
     */
    #[Get('/get-one/{cityGallery}')]
    #[Operation(tags: ['City Gallery'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CityGalleryParameters::class)]
    #[Response(factory: CityGalleryResponse::class)]
    public function getOneCityGallery(Request $request, CityGallery $cityGallery): JsonResponse
    {
        $language = $request->header('language', 'uz');

        $cityGallery->title = $cityGallery->getTranslatedAttribute('title', $language);

        unset($cityGallery->translations);

        return $this->success($cityGallery);

    }

}
