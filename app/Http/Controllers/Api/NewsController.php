<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommunityRequest;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\MeetingUser;
use App\Models\Public\PostsTag;
use App\Models\Public\PostTag;
use App\Models\PublicAssociation\Community;
use App\Models\PublicAssociation\CommunityAttachment;
use App\OpenApi\RequestBodies\CreateCommunityRequestBody;
use App\OpenApi\Responses\AllCommunityNewResponse;
use App\OpenApi\Responses\CreateCommunityResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Page;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all Meetings
     */
    #[Get('/news')]
    #[Operation(tags: ['News'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAlNews(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $type = $request->type ?? '';
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 10;
        $news = \TCG\Voyager\Models\Post::where('status', 'PUBLISHED');
        /*withTranslations($language)->*/
        if (strlen($type) > 0) {
            $news->leftJoin('categories', 'categories.id', '=', 'posts.category_id')
                ->where('categories.key', $type)->select('posts.*');
        }
        $news = $news->orderBy('posts.created_at', 'desc')->paginate($per_page);
        foreach ($news as &$new) {
            $new->title = $new->getTranslatedAttribute("title", $language);
            $new->body = $new->getTranslatedAttribute("body", $language);
//            $new = $new->translate($language);
            unset($new->translations);
            $tags = PostsTag::where('post_id', $new->id)->pluck('post_tag_id');
            $tags = PostTag::whereIn('id', $tags)->pluck('name')->implode(', ');
            $new->tags = $tags;
        }
        return $this->success($news);
    }


    /**
     * Create community News
     **/
    #[Get('/new/{id}')]
    #[Operation(tags: ['News'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function createNews(Request $request, $id): JsonResponse
    {
        $language = $request->header('language');
        $post = \TCG\Voyager\Models\Post::where('id', $id)->first();
        if ($post){
            $post->view = (int) $post->view + 1;
            $post->save();

            $post->title = $post->getTranslatedAttribute("title", $language);
            $post->seo_title = $post->getTranslatedAttribute("seo_title", $language);
            $post->excerpt = $post->getTranslatedAttribute("excerpt", $language);
            $post->body = $post->getTranslatedAttribute("body", $language);
            $post->slug = $post->getTranslatedAttribute("slug", $language);
            $post->meta_description = $post->getTranslatedAttribute("meta_description", $language);
            $post->meta_keywords = $post->getTranslatedAttribute("meta_keywords", $language);
            $post->tags = $post->getTranslatedAttribute("tags", $language);
            unset($post->translations);

            return $this->success($post);
        }
        return response()->json(['error' => 'Not Found New'], 400);

    }


}
