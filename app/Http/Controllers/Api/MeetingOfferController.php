<?php

namespace App\Http\Controllers\Api;

use App\Enums\CompatriotTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExpertSuggestionRequest;
use App\Http\Resources\ExpertSuggestionResource;
use App\Models\Meeting\MeetingOffer;
use App\Models\Userdata\CompatriotExpert;
use App\OpenApi\RequestBodies\CreateExpertSuggestionRequestBody;
use App\OpenApi\Responses\AllExpertSuggestionResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('meeting-offer')]
#[PathItem]
class MeetingOfferController extends Controller
{
    /**
     * Insert meeting offer
     */
    #[Post('/create')]
    #[Operation(tags: ['Meeting'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: CreateExpertSuggestionRequestBody::class)]
    #[Response(factory: AllExpertSuggestionResponse::class)]
    public function createMeetingOffer(CreateExpertSuggestionRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'meetingOffer');
        }

        $meetingOffer = MeetingOffer::query()->create([
            'user_id' => auth()->id(),
            'offer' => $data['suggestions'],
            'additional_information' => $data['additional_information'],
            'image' => $data['image'],
            'verified' => false
        ]);

        if ($meetingOffer) {
            return $this->success($meetingOffer);
        }
        return $this->error([], 'no data created');
    }

}
