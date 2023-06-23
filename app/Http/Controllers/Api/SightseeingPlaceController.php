<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SightseeingResource;
use App\Models\AboutUzbekistan\City;
use App\Models\AboutUzbekistan\SightseeingPlace;
use App\OpenApi\Parameters\SightseeingParameters;
use App\OpenApi\Parameters\SightseeingPlaceParameters;
use App\OpenApi\Responses\SightseeingResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('sightseeing')]
#[PathItem]
class SightseeingPlaceController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['About Sightseeing of Uzb'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: SightseeingPlaceParameters::class)]
    #[Response(factory: SightseeingResponse::class)]
    public function getAllSightseeing(Request $request): JsonResponse
    {
        $language = $request->header('language');
        $paginate = $request->query('paginate');
        $city = $request->query('city');

        if ($paginate && $city){
            $cities = City::query()->find($city)->sightseeingPlaces()->paginate($paginate);
            foreach ($cities as &$place){
                $place->city->name = $place->city->getTranslatedAttribute('name', $language);
                $place->title = $place->getTranslatedAttribute('title', $language);
                $place->content_title = $place->getTranslatedAttribute('content_title', $language);
                $place->text = $place->getTranslatedAttribute('text', $language);
                unset($place->translations);
            }
            unset($cities->translations);

            return $this->success($cities);

        }
        elseif ($paginate){
            $cities = City::query()->paginate($paginate);

            foreach ($cities as &$city){
                $city->name = $city->getTranslatedAttribute('name', $language);
                foreach ($city->sightseeingPlaces as &$place){
                    $place->title = $place->getTranslatedAttribute('title', $language);
                    $place->content_title = $place->getTranslatedAttribute('content_title', $language);
                    $place->text = $place->getTranslatedAttribute('text', $language);
                    unset($place->translations);
                }
                unset($city->translations);
            }

            return $this->success($cities);

        }
        elseif ($city){
            $cities = City::query()->find($city);
            $cities->name = $cities->getTranslatedAttribute('name', $language);

            foreach ($cities->sightseeingPlaces as &$place){
                $place->title = $place->getTranslatedAttribute('title', $language);
                $place->content_title = $place->getTranslatedAttribute('content_title', $language);
                $place->text = $place->getTranslatedAttribute('text', $language);
                unset($place->translations);
            }

            unset($cities->translations);


            return $this->success($cities);
        }

        $cities = City::query()->get();
        if ($cities){
            foreach ($cities as &$city){
                $city->name = $city->getTranslatedAttribute('name', $language);
                foreach ($city->sightseeingPlaces as &$place){
                    $place->title = $place->getTranslatedAttribute('title', $language);
                    $place->content_title = $place->getTranslatedAttribute('content_title', $language);
                    $place->text = $place->getTranslatedAttribute('text', $language);
                    unset($place->translations);
                }
                unset($city->translations);
            }
            return $this->success($cities);
        }

        return $this->error([], 'No data', 200);
    }

    /**
     * @param Request $request
     * @param SightseeingPlace $sightseeingPlace
     * @return JsonResponse
     */
    #[Get('/get-one/{sightseeingPlace}')]
    #[Operation(tags: ['About Sightseeing of Uzb'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: SightseeingParameters::class)]
    #[Response(factory: SightseeingResponse::class)]
    public function getOneSightseeing(Request $request, SightseeingPlace $sightseeingPlace): JsonResponse
    {
        $language = $request->header('language');
        $sightseeing = $sightseeingPlace->city()->with(['sightseeingPlaces', 'cityGalleries', 'cityVideos', 'city3Ds', 'cityContentInfos'])->get();

        foreach ($sightseeing as &$item){

            $item->name = $item->getTranslatedAttribute("name", $language);

            foreach ($item->cityGalleries as &$cityGallery){
                $cityGallery->title = $cityGallery->getTranslatedAttribute("title", $language);
                unset($cityGallery->translations);
            }

            foreach ($item->sightseeingPlaces as &$sightseeingPlace){
                $sightseeingPlace->title = $sightseeingPlace->getTranslatedAttribute("title", $language);
                $sightseeingPlace->content_title = $sightseeingPlace->getTranslatedAttribute("content_title", $language);
                $sightseeingPlace->text = $sightseeingPlace->getTranslatedAttribute("text", $language);
                unset($sightseeingPlace->translations);
            }
            foreach ($item->cityVideos as &$cityVideo){
                $cityVideo->title = $sightseeingPlace->getTranslatedAttribute("title", $language);
                unset($cityVideo->translations);
            }
            foreach ($item->city3Ds as &$city3D){
                $city3D->title = $city3D->getTranslatedAttribute("title", $language);
                unset($city3D->translations);
            }
            foreach ($item->cityContentInfos as &$cityContentInfo){
                $cityContentInfo->title = $cityContentInfo->getTranslatedAttribute("title", $language);
                $cityContentInfo->content = $cityContentInfo->getTranslatedAttribute("content", $language);
                unset($cityContentInfo->translations);
            }
            unset($item->translations);
        }

        $sightseeingPlace->title = $sightseeingPlace->getTranslatedAttribute("title", $language);
        $sightseeingPlace->content_title = $sightseeingPlace->getTranslatedAttribute("content_title", $language);
        $sightseeingPlace->text = $sightseeingPlace->getTranslatedAttribute("text", $language);
        unset($sightseeingPlace->translations);

        if ($sightseeing){
            return $this->success([$sightseeingPlace, ...$sightseeing]);
        }

        return $this->error([], 'No data');
    }
}
