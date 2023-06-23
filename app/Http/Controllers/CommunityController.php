<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommunityRequest;
use App\Http\Resources\CommunityNewResource;
use App\Http\Resources\CommunityRegionResource;
use App\Models\Public\Location;
use App\Models\Public\PostsTag;
use App\Models\Public\PostTag;
use App\Models\PublicAssociation\Community;
use App\Models\PublicAssociation\CommunityAttachment;
use App\Models\PublicAssociation\CommunityEvent;
use App\Models\PublicAssociation\CommunityNew;
use App\OpenApi\Parameters\CommunityParameters;
use App\OpenApi\RequestBodies\CreateCommunityRequestBody;
use App\OpenApi\Responses\AllCommunityEventResponse;
use App\OpenApi\Responses\AllCommunityNewResponse;
use App\OpenApi\Responses\AllCommunityRegionResponse;
use App\OpenApi\Responses\AllCommunityResponse;
use App\OpenApi\Responses\CreateCommunityResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Page;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('community')]
#[PathItem]
class CommunityController extends Controller
{
    /**
     * Get all region with community info
     */
    #[Get('/all-region')]
    #[Operation(tags: ['Community'], method: 'GET')]
    #[Response(factory: AllCommunityRegionResponse::class)]
    public function getAllRegion(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $regions = Location::whereNull('location_id')
            ->select('locations.id', 'locations.name', 'locations.code', 'locations.flag', DB::raw('(select count(communities.region_id) from communities where communities.region_id = locations.id) as count'))
//            ->translate(app()->getLocale())
            ->get();
        foreach ($regions as &$new) {
            $new->name = $new->getTranslatedAttribute("name", $language);
            $new->b_title = $new->getTranslatedAttribute("b_title", $language);
            $new->b_description = $new->getTranslatedAttribute("b_description", $language);
            unset($new->translations);
        }
        return $this->success(CommunityRegionResource::collection($regions));
    }

    /**
     * Get all community info
     */
    #[Get('/all-community')]
    #[Operation(tags: ['Community'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: CommunityParameters::class)]
    #[Response(factory: AllCommunityResponse::class)]
    public function getAllCommunity(Request $request): JsonResponse
    {
        $user_id = $request->user_id;
//        dd($user_id);
        $language = $request->header('language', 'uz');
        $region_id = isset($request->region_id) && (int)$request->region_id > 0 ? $request->region_id : 0;
        $page = isset($request->page) && (int)$request->page > 0 ? $request->page : 1;
        $per_page = $request->per_page ?? 8;
        $communities = Community::
        leftJoin('locations as reg', 'communities.region_id', '=', 'reg.id')
            ->leftJoin('locations as cit', 'communities.city_id', '=', 'cit.id')
            ->select('communities.*', 'reg.name as region_name', 'cit.name as city_name',
                'reg.b_title as b_title', 'reg.b_description as b_description', 'reg.b_image as b_image',
                DB::raw('(select count(*) from community_news where community_news.community_id = communities.id) as news'))//            ->with('attachments')
        ;
        if ($region_id > 0) {
            $communities->where('region_id', $region_id);
        }
        if (isset($request->user_id)) {
            $communities = $communities->where('communities.user_id', $user_id);
        }
        if (isset($request->per_page)) {
            $communities = $communities->paginate($per_page);
        } else {
            $communities = $communities->paginate(9999999999);
        }
        foreach ($communities as $j => &$new) {
//            $new->name = $new->getTranslatedAttribute("name", $language);
//            $new->title = $new->getTranslatedAttribute("title", $language);
//            $new->description = $new->getTranslatedAttribute("description", $language);
//            $new->document = $new->getTranslatedAttribute("document", $language);
//            $new->director = $new->getTranslatedAttribute("director", $language);
//            $new->work = $new->getTranslatedAttribute("work", $language);
            $communities[$j]->attachments = $new->attachments()->pluck('path')->toArray();
//            dd($new);
//            unset($new->translations);
        }
        return $this->success($communities);
    }

    /**
     * Create community
     **/
    #[Post('/create')]
    #[Operation(tags: ['Community'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    #[RequestBody(factory: CreateCommunityRequestBody::class)]
    #[Response(factory: CreateCommunityResponse::class)]
    public function createCommunity(CreateCommunityRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->guard('api')->id();
        $data['created_date'] = Carbon::parse($data['created_date'])->format('Y-m-d');
        $attachments = $data['attachments'];
        $community = Community::query()->create($data);
        if ($community) {
            if (array($attachments) && count($attachments) > 0) {
                $attachCount = 0;
                $attach = [];
                foreach ($attachments as $attachment) {
                    CommunityAttachment::query()->create([
                        "type" => 'community',
                        "path" => $attachment,
                        "order" => $attachCount,
                        "community_id" => $community->id,
                    ]);
                    $attachCount++;
                    $attach[] = $attachment;
                }
                $community->attachments = $attach;
            }
            return $this->success($community);
        }
        return $this->error([], 'no data created');
    }

    /**
     * Create community News
     **/
    #[Post('/news')]
    #[Operation(tags: ['Community'], method: 'POST')]
    public function createCommunityNews(Request $request): JsonResponse
    {
        $request->validate([
            'community_id' => 'required|integer',
            'title' => 'required|min:6',
            'content' => 'required|min:6',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->guard('api')->id();
        $data['description'] = "";
        $attachments = $data['attachments'];
        $community = Community::where('id', $data['community_id'])->where('user_id', $data['user_id'])->first();
        if (!$community) {
            return response()->json(['error' => 'Not Found Community Or permission'], 400);

        }
        $communityNew = CommunityNew::query()->create($data);
        if ($communityNew) {
            if (array($attachments) && count($attachments) > 0) {
                $attachCount = 0;
                $attach = [];
                foreach ($attachments as $attachment) {
                    CommunityAttachment::query()->create([
                        "type" => 'community',
                        "path" => $attachment,
                        "order" => $attachCount,
                        "community_news_id" => $communityNew->id,
                    ]);
                    $attachCount++;
                    $attach[] = $attachment;
                }
                $communityNew->attachments = $attach;
            }
            return $this->success($communityNew);
        }
        return $this->error([], 'no data created');
    }
    /**
     * Create community Event
     **/
    #[Post('/event')]
    #[Operation(tags: ['Community'], method: 'POST')]
    public function createCommunityEvent(Request $request): JsonResponse
    {
        $request->validate([
            'community_id' => 'required|integer',
            'title' => 'required|min:6',
            'content' => 'required|min:6',
        ]);
        $data = $request->all();
        $data['user_id'] = auth()->guard('api')->id();
        $data['status'] = false;
        $data['date'] = now();
        $attachments = $data['attachments'];
        $community = Community::where('id', $data['community_id'])->where('user_id', $data['user_id'])->first();
        if (!$community) {
            return response()->json(['error' => 'Not Found Community Or permission'], 400);

        }
        $communityNew = CommunityEvent::query()->create($data);
        if ($communityNew) {
            if (array($attachments) && count($attachments) > 0) {
//                $attachCount = 0;
//                $attach = [];
//                foreach ($attachments as $attachment) {
//                    CommunityAttachment::query()->create([
//                        "type" => 'community',
//                        "path" => $attachment,
//                        "order" => $attachCount,
//                        "community_event_id" => $communityNew->id,
//                    ]);
//                    $attachCount++;
//                    $attach[] = $attachment;
//                }
//                $communityNew->attachments = $attach;
//                dd(json_encode($attachments, true));
                $communityNew->image = json_encode($attachments, true);
                $communityNew->save();
            }
            return $this->success($communityNew);
        }
        return $this->error([], 'no data created');
    }


    /**
     * Get all community Events info
     */
    #[Get('/all-event')]
    #[Operation(tags: ['Community'], method: 'GET')]
    #[Response(factory: AllCommunityEventResponse::class)]
    public function getAllEvents(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;

        $communities = CommunityEvent::query()->where('status', true)
            ->paginate($per_page);
        foreach ($communities as &$new) {
            $new->title = $new->getTranslatedAttribute("title", $language);
            $new->content = $new->getTranslatedAttribute("content", $language);
            $new->attachments = json_decode($new->image);
            unset($new->translations);
            $tags = PostsTag::where('community_event_id', $new->id)->pluck('post_tag_id');
            $tags = PostTag::whereIn('id', $tags)->pluck('name')->implode(', ');
            $new->tags = $tags;
        }
        return $this->success($communities);
    }

    /**
     * Create community News
     **/
    #[Get('/event/{id}')]
    #[Operation(tags: ['Community'], method: 'GET')]
    public function getEvent(Request $request, $id): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $post = CommunityEvent::where('id', $id)->first();
        if ($post) {
            $post->view = (int)$post->view + 1;
            $post->save();
            $post->title = $post->getTranslatedAttribute("title", $language);
            $post->body = $post->getTranslatedAttribute("content", $language);
            $post->attachments = json_decode($post->image);

            unset($post->translations);
            $tags = PostsTag::where('community_event_id', $post->id)->pluck('post_tag_id');
            $tags = PostTag::whereIn('id', $tags)->pluck('name')->implode(', ');
            $post->tags = $tags;
            return $this->success($post);
        }
        return response()->json(['error' => 'Not Found New'], 400);

    }

   /**
     * Get all community News info
     */
    #[Get('/all-new')]
    #[Operation(tags: ['Community'], method: 'GET')]
    #[Response(factory: AllCommunityNewResponse::class)]
    public function getAllNews(): JsonResponse
    {
        $communities = CommunityNew::all();
        return $this->success(CommunityNewResource::collection($communities));
    }

    /**
     * Get all community Page info
     */
    #[Get('/page')]
    #[Operation(tags: ['Community'], method: 'GET')]
    #[Response(factory: AllCommunityNewResponse::class)]
    public function getPage(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $page = Page::where('meta_keywords', 'community')->first();
        if ($page) {
            $page->title = $page->getTranslatedAttribute("title", $language);
            $page->body = $page->getTranslatedAttribute("body", $language);
        }
        return $this->success($page);
    }
}
