<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\AboutUzbekistan\City;
use App\OpenApi\Parameters\CityParameters;
use App\OpenApi\Parameters\LanguageCityParameters;
use App\OpenApi\Responses\CityResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('city')]
#[PathItem]
class CityController extends Controller
{
    /**
     * get all cities
     */
    #[Get('/get-all')]
    #[Operation(tags: ['City'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: LanguageCityParameters::class)]
    #[Response(factory: CityResponse::class)]
    public function getAllCities(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');

        $cities = City::query()->with(['sightseeingPlaces', 'cityGalleries', 'cityVideos', 'city3Ds', 'cityContentInfos'])->get();

        foreach ($cities as &$city){
            $city->name = $city->getTranslatedAttribute("name", $language);

            foreach ($city->sightseeingPlaces as &$sightseeingPlace){
                $sightseeingPlace->title = $sightseeingPlace->getTranslatedAttribute("title", $language);
                $sightseeingPlace->content_title = $sightseeingPlace->getTranslatedAttribute("content_title", $language);
                $sightseeingPlace->text = $sightseeingPlace->getTranslatedAttribute("text", $language);
                unset($sightseeingPlace->translations);
            }

            foreach ($city->cityGalleries as &$cityGallery){
                $cityGallery->title = $cityGallery->getTranslatedAttribute("title", $language);
                unset($cityGallery->translations);
            }

            foreach ($city->cityVideos as $cityVideo){
                $cityVideo->title = $cityVideo->getTranslatedAttribute("title", $language);
                $cityVideo->content = $cityVideo->getTranslatedAttribute("content", $language);
                unset($cityVideo->translations);            }

            foreach ($city->city3Ds as $city3D){
                $city3D->title = $city3D->getTranslatedAttribute("title", $language);
                unset($city3D->translations);
            }

            foreach ($city->cityContentInfos as $cityContentInfo){
                $cityContentInfo->title = $cityContentInfo->getTranslatedAttribute("title", $language);
                $cityContentInfo->content = $cityContentInfo->getTranslatedAttribute("content", $language);
                unset($cityContentInfo->translations);
            }

            unset($city->translations);
        }

        if ($cities->count()>0){
            return $this->success($cities);
        }

        return $this->error([], 'No data');
    }

    /**
     * get one city
     */
    #[Get('/get-one/{city}')]
    #[Operation(tags: ['City'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CityParameters::class)]
    #[Response(factory: CityResponse::class)]
    public function getOneCity(Request $request, City $city): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $city->name = $city->getTranslatedAttribute("name", $language);

        foreach ($city->sightseeingPlaces as &$sightseeingPlace){
            $sightseeingPlace->title = $sightseeingPlace->getTranslatedAttribute("title", $language);
            $sightseeingPlace->content_title = $sightseeingPlace->getTranslatedAttribute("content_title", $language);
            $sightseeingPlace->text = $sightseeingPlace->getTranslatedAttribute("text", $language);
            unset($sightseeingPlace->translations);
        }

        foreach ($city->cityGalleries as &$cityGallery){
            $cityGallery->title = $cityGallery->getTranslatedAttribute("title", $language);
            unset($cityGallery->translations);
        }

        foreach ($city->cityVideos as $cityVideo){
            $cityVideo->title = $cityVideo->getTranslatedAttribute("title", $language);
            $cityVideo->content = $cityVideo->getTranslatedAttribute("content", $language);
            unset($cityVideo->translations);            }

        foreach ($city->city3Ds as $city3D){
            $city3D->title = $city3D->getTranslatedAttribute("title", $language);
            unset($city3D->translations);
        }

        foreach ($city->cityContentInfos as $cityContentInfo){
            $cityContentInfo->title = $cityContentInfo->getTranslatedAttribute("title", $language);
            $cityContentInfo->content = $cityContentInfo->getTranslatedAttribute("content", $language);
            unset($cityContentInfo->translations);
        }

        unset($city->translations);

        return $this->success($city);
    }


}
