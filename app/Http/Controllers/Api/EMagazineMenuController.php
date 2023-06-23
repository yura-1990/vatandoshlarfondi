<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EMagazine\AboutEMagazine;
use App\Models\EMagazine\EMagazineMenu;
use App\OpenApi\Parameters\AboutEMagazineParameters;
use App\OpenApi\Parameters\EMagazineMenuParameters;
use App\OpenApi\Parameters\EMagazineParameters;
use App\OpenApi\Parameters\OneEMagazineMenuParameters;
use App\OpenApi\Responses\AboutEMagazineResponse;
use App\OpenApi\Responses\EMagazineMenuResponse;
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
class EMagazineMenuController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-menu')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: EMagazineMenuParameters::class)]
    #[Response(factory: EMagazineMenuResponse::class)]
    public function getMenuEMagazine(Request $request): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';
        $EMagazineMenus = EMagazineMenu::query()->get();

        foreach ($EMagazineMenus as &$EMagazineMenu){
            $EMagazineMenu->title = $EMagazineMenu->getTranslatedAttribute("title", $language);
            $EMagazineMenu->text = $EMagazineMenu->getTranslatedAttribute("text", $language);
            $EMagazineMenu->name = $EMagazineMenu->getTranslatedAttribute("name", $language);

            unset($EMagazineMenu->translations);
        }

        if ($EMagazineMenus){
            return $this->success($EMagazineMenus);
        }

        return $this->error([], 'No data');
    }

    /**
     * @param Request $request
     * @param EMagazineMenu $EMagazineMenu
     * @return JsonResponse
     */
    #[Get('/get-one-menu/{EMagazineMenu}')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: OneEMagazineMenuParameters::class)]
    #[Response(factory: EMagazineMenuResponse::class)]
    public function getOneMenuEMagazine(Request $request, EMagazineMenu $EMagazineMenu): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';

        $EMagazineMenu->title = $EMagazineMenu->getTranslatedAttribute("title", $language);
        $EMagazineMenu->text = $EMagazineMenu->getTranslatedAttribute("text", $language);
        $EMagazineMenu->name = $EMagazineMenu->getTranslatedAttribute("name", $language);

        unset($EMagazineMenu->translations);

        return $this->success($EMagazineMenu);
    }

}
