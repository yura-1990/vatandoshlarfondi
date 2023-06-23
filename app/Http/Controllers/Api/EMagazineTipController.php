<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EMagazine\EMagazine;
use App\Models\EMagazine\EMagazineTip;
use App\OpenApi\Parameters\EMagazineParameters;
use App\OpenApi\Parameters\EMagazineTipParameters;
use App\OpenApi\Parameters\OneEMagazineTipParameters;
use App\OpenApi\Responses\EMagazineResponse;
use App\OpenApi\Responses\EMagazineTipResponse;
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
class EMagazineTipController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/get-tips')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: EMagazineTipParameters::class)]
    #[Response(factory: EMagazineTipResponse::class)]
    public function getAllEMagazine(Request $request): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';
        $eMagazineTips = EMagazineTip::query()->orderByDesc('created_at')->get();

        foreach ($eMagazineTips as &$eMagazineTip){
            $eMagazineTip->title = $eMagazineTip->getTranslatedAttribute("title", $language);
            $eMagazineTip->content = $eMagazineTip->getTranslatedAttribute("content", $language);
            unset($eMagazineTip->translations);
        }

        if ($eMagazineTips){
            return $this->success($eMagazineTips);
        }

        return $this->error([], 'No data');
    }

    /**
     * @param Request $request
     * @param EMagazineTip $EMagazineTip
     * @return JsonResponse
     */
    #[Get('/get-one-tips/{EMagazineTip}')]
    #[Operation(tags: ['EMagazine'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: OneEMagazineTipParameters::class)]
    #[Response(factory: EMagazineTipResponse::class)]
    public function getOneEMagazine(Request $request, EMagazineTip $EMagazineTip): JsonResponse
    {
        $language = $request->header('language') ?? 'uz';

        $EMagazineTip->title = $EMagazineTip->getTranslatedAttribute("title", $language);
        $EMagazineTip->content = $EMagazineTip->getTranslatedAttribute("content", $language);
        unset($EMagazineTip->translations);

        if ($EMagazineTip){
            return $this->success($EMagazineTip);
        }

        return $this->error([], 'No data');
    }
}
