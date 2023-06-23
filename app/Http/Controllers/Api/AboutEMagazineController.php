<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EMagazine\AboutEMagazine;
use App\Models\EMagazine\EMagazine;
use App\OpenApi\Parameters\AboutEMagazineParameters;
use App\OpenApi\Parameters\EMagazineParameters;
use App\OpenApi\Parameters\OneAboutEMagazineParameters;
use App\OpenApi\Responses\AboutEMagazineResponse;
use App\OpenApi\Responses\EMagazineResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('magazine')]
#[PathItem]
class AboutEMagazineController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-about')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: AboutEMagazineParameters::class)]
    #[Response(factory: AboutEMagazineResponse::class)]
    public function getAllEMagazine(Request $request): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';
        $aboutEMagazines = AboutEMagazine::query()->orderByDesc('created_at')->get();

        foreach ($aboutEMagazines as &$aboutEMagazine){
            $aboutEMagazine->title = $aboutEMagazine->getTranslatedAttribute("title", $language);
            $aboutEMagazine->short_content = $aboutEMagazine->getTranslatedAttribute("short_title", $language);

            unset($aboutEMagazine->translations);
        }

        if ($aboutEMagazines){
            return $this->success($aboutEMagazines);
        }

        return $this->error([], 'No data');
    }

    /**
     * @param Request $request
     * @param AboutEMagazine $aboutEMagazine
     * @return JsonResponse
     */
    #[Get('/get-one-about/{aboutEMagazine}')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: OneAboutEMagazineParameters::class)]
    #[Response(factory: AboutEMagazineResponse::class)]
    public function getOneEMagazine(Request $request, AboutEMagazine $aboutEMagazine): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';

        $aboutEMagazine->title = $aboutEMagazine->getTranslatedAttribute("title", $language);
        $aboutEMagazine->short_content = $aboutEMagazine->getTranslatedAttribute("short_title", $language);

        unset($aboutEMagazine->translations);

        return $this->success($aboutEMagazine);
    }
}
