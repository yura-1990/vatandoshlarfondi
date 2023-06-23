<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationCityResource;
use App\Models\Public\Location;
use App\OpenApi\Parameters\LocationCityParameters;
use App\OpenApi\Responses\GetAllLocationResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('locations')]
#[PathItem]
class LocationController extends Controller
{
    /**
     * get all location
     */
    #[Get('/get-all')]
    #[Operation(tags: ['All Location'], method: 'GET')]
    #[Response(factory: GetAllLocationResponse::class)]
    public function getAllLocation(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        if (isset($request->location_id)){
            $locations = Location::where('location_id', $request->location_id)->get();
        }
        else{
            $locations = Location::whereNull('location_id')->get();
        }
        foreach ($locations as &$new) {
            $new->name = $new->getTranslatedAttribute("name", $language);
            $new->b_title = $new->getTranslatedAttribute("b_title", $language);
            $new->b_description = $new->getTranslatedAttribute("b_description", $language);
            unset($new->translations);
        }
        return $this->success($locations);
    }

    /**
     * Get locations with cities
     */
    #[Get('/get-with-cities')]
    #[Operation(tags: ['All Location'], method: 'GET')]
    #[Response(factory: GetAllLocationResponse::class)]
    public function getLocationWithCities(): JsonResponse
    {
        $locations = LocationCityResource::collection(Location::query()->get());
        if ($locations->count()>0){
            return $this->success($locations);
        }

        return $this->error([], 'No data');
    }

    /**
     * Get one location with cities
     */
    #[Get('/get-one-with-cities/{location}')]
    #[Operation(tags: ['All Location'], method: 'GET')]
    #[Parameters(factory: LocationCityParameters::class)]
    #[Response(factory: GetAllLocationResponse::class)]
    public function getOneLocationWithCities(Location $location): JsonResponse
    {
        if ($location->count()>0){
            return $this->success(new LocationCityResource($location));
        }

        return $this->error([], 'No data');
    }
}
