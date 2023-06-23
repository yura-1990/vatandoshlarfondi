<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUzbekistanPageMenuResource;
use App\Models\AboutUzbekistan\AboutUzbekistanPageMenu;
use App\OpenApi\Parameters\AboutUzbekistanPageMenuParameters;
use App\OpenApi\Parameters\AboutUzbPageMenuParameters;
use App\OpenApi\Responses\AboutUzbekistanPageMenuResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('about-uzb')]
#[PathItem]
class AboutUzbekistanPageMenuController extends Controller
{
    /**
     * Get all menu data about Uzb
     */
    #[Get('/get-all')]
    #[Operation(tags: ['About Uzbekistan'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: AboutUzbPageMenuParameters::class)]
    #[Response(factory: AboutUzbekistanPageMenuResponse::class)]
    public function getAboutUzbekistanPageMenu(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $aboutUzbekistanPageMenus = AboutUzbekistanPageMenu::query()->get();

        foreach ($aboutUzbekistanPageMenus as &$menu){
            $menu->name = $menu->getTranslatedAttribute("name", $language);

            foreach ($menu->pageMenuContents as &$content){
                $content->title = $content->getTranslatedAttribute("title", $language);
                $content->text = $content->getTranslatedAttribute("text", $language);
                unset($content->translations);
            }
            unset($menu->translations);
        }

        if ($aboutUzbekistanPageMenus){
            return $this->success($aboutUzbekistanPageMenus);
        }

        return $this->error([], 'no data');
    }

    /**
     * Get one menu data about Uzb
     */
    #[Get('/get-one/{aboutUzbekistanPageMenu}')]
    #[Operation(tags: ['About Uzbekistan'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: AboutUzbekistanPageMenuParameters::class)]
    #[Response(factory: AboutUzbekistanPageMenuResponse::class)]
    public function getOneMenuDataAboutUzb(Request $request, AboutUzbekistanPageMenu $aboutUzbekistanPageMenu): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $aboutUzbekistanPageMenu->name = $aboutUzbekistanPageMenu->getTranslatedAttribute("name", $language);

        foreach ($aboutUzbekistanPageMenu->pageMenuContents as &$content){
            $content->title = $content-> getTranslatedAttribute("title", $language);
            $content->text = $content-> getTranslatedAttribute("text", $language);
            unset($content->translations);
        }
        unset($aboutUzbekistanPageMenu->translations);

        return $this->success($aboutUzbekistanPageMenu);
    }
}
