<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EMagazine\EMagazine;
use App\OpenApi\Parameters\EMagazineParameters;
use App\OpenApi\Parameters\OneEMagazineParameters;
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
class EMagazineController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-popular')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: EMagazineParameters::class)]
    #[Response(factory: EMagazineResponse::class)]
    public function getPopularEMagazine(Request $request): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';
        $paginate = $request->query('paginate') ?? 12;
        $eMagazines = EMagazine::query()->orderByDesc('viewers')->paginate($paginate);

        foreach ($eMagazines as &$eMagazine){
            $eMagazine->title = $eMagazine->getTranslatedAttribute("title", $language);
            $eMagazine->short_content = $eMagazine->getTranslatedAttribute("short_content", $language);
            $eMagazine->text = $eMagazine->getTranslatedAttribute("text", $language);

            $eMagazine->month->name = $eMagazine->month->getTranslatedAttribute("name", $language);
            unset($eMagazine->month->translations);
            foreach ($eMagazine->aboutEMagazines as &$magazine){
                $magazine->short_title = $magazine->getTranslatedAttribute("short_content", $language);
                $magazine->title = $magazine->getTranslatedAttribute("title", $language);
                unset($magazine->translations);
            }
            unset($eMagazine->translations);
        }

        if ($eMagazines){
            return $this->success($eMagazines);
        }

        return $this->error([], 'No data');
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-all')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: EMagazineParameters::class)]
    #[Response(factory: EMagazineResponse::class)]
    public function getAllEMagazine(Request $request): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';
        $paginate = $request->query('paginate') ?? 12;
        $eMagazines = EMagazine::query()->orderByDesc('updated_at')->paginate($paginate);

        foreach ($eMagazines as &$eMagazine){
            $eMagazine->title = $eMagazine->getTranslatedAttribute("title", $language);
            $eMagazine->short_content = $eMagazine->getTranslatedAttribute("short_content", $language);
            $eMagazine->text = $eMagazine->getTranslatedAttribute("text", $language);

            $eMagazine->month->name = $eMagazine->month->getTranslatedAttribute("name", $language);
            unset($eMagazine->month->translations);
            foreach ($eMagazine->aboutEMagazines as &$magazine){
                $magazine->short_title = $magazine->getTranslatedAttribute("short_content", $language);
                $magazine->title = $magazine->getTranslatedAttribute("title", $language);
                unset($magazine->translations);
            }
            unset($eMagazine->translations);
        }

        if ($eMagazines){
            return $this->success($eMagazines);
        }

        return $this->error([], 'No data');
    }

    /**
     * @param Request $request
     * @param EMagazine $EMagazine
     * @return JsonResponse
     */
    #[Get('/get-one/{EMagazine}')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: OneEMagazineParameters::class)]
    #[Response(factory: EMagazineResponse::class)]
    public function getOne(Request $request, EMagazine $EMagazine): JsonResponse
    {
        $language = $request->header('language');

        $EMagazine->title = $EMagazine->getTranslatedAttribute("title", $language);
        $EMagazine->short_content = $EMagazine->getTranslatedAttribute("short_content", $language);
        $EMagazine->text = $EMagazine->getTranslatedAttribute("text", $language);

        $EMagazine->month->name = $EMagazine->month->getTranslatedAttribute("name", $language);
        unset($EMagazine->month->translations);

        foreach ($EMagazine->aboutEMagazines as &$eMagazine){
            $eMagazine->short_title = $eMagazine->getTranslatedAttribute("short_content", $language);
            $eMagazine->title = $eMagazine->getTranslatedAttribute("title", $language);
            unset($eMagazine->translations);
        }

        unset($EMagazine->translations);

        return $this->success($EMagazine);
    }


}
