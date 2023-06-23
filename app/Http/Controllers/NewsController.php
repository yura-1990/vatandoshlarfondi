<?php

namespace App\Http\Controllers;

use App\Models\Public\Location;
use App\Models\Public\PostsTag;
use App\Models\Public\PostTag;
use App\OpenApi\Parameters\LocationNewsAndEventsParameters;
use App\OpenApi\Parameters\NewsParameters;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Post;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;

#[Prefix('all-news')]
#[PathItem]
class NewsController extends Controller
{
    /**
     * Get all Meetings
     */
    #[Get('/news')]
    #[Operation(tags: ['News'], method: 'GET')]
    #[Parameters(factory: NewsParameters::class)]
    public function getAlNews(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $tag = $request->query('tag', '');
        $paginate = $request->query('paginate', null);
        $postTag = Post::query();
        if ($tag && $paginate){
            $postTag = Post::query()->where('tags', "LIKE", "%$tag%")->orderByDesc('data')->paginate($paginate);
        } elseif ($tag){
            $postTag = Post::query()->where('tags', "LIKE", "%$tag%")->orderByDesc('data')->get();
        } elseif ($paginate){
            $postTag = Post::query()->orderByDesc('data')->paginate($paginate);
        } else {
            $postTag = Post::query()->orderByDesc('data')->get();
        }

        foreach ($postTag as &$item){
            $item->title=$item->getTranslatedAttribute("title", $language);
            $item->seo_title=$item->getTranslatedAttribute("seo_title", $language);
            $item->excerpt=$item->getTranslatedAttribute("excerpt", $language);
            $item->body=$item->getTranslatedAttribute("body", $language);
            $item->slug=$item->getTranslatedAttribute("slug", $language);
            $item->meta_description=$item->getTranslatedAttribute("meta_description", $language);
            $item->meta_keywords=$item->getTranslatedAttribute("meta_keywords", $language);
            $item->tags=$item->getTranslatedAttribute("tags", $language);
            unset($item->translations);
        }

        return $this->success($postTag);
    }


    /**
     * Create community News
     **/
    #[Get('/new/{id}')]
    #[Operation(tags: ['News'], method: 'GET')]
    public function createNews(Request $request, $id): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $post = Post::query()->where('id', $id)->first();

        if ($post){
            $post->view = (int) $post->view + 1;
            $post->save();
        }

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

    /**
     * All location community News
     **/
    #[Get('/all-location-new')]
    #[Operation(tags: ['News'], method: 'GET')]
    public function locationNews(): JsonResponse
    {
        $posts = Location::query()->withCount('posts', 'communityEvents')->get();
        if ($posts){
            return $this->success($posts);
        }
        return response()->json(['error' => 'Not Found New'], 400);

    }

    /**
     * One location News
     **/
    #[Get('/location-new/{id}')]
    #[Operation(tags: ['News'], method: 'GET')]
    #[Parameters(factory: LocationNewsAndEventsParameters::class)]
    public function oneLocationNews(Request $request, $id): JsonResponse
    {
        $location = Location::query()->with('posts', 'communityEvents')->find($id);
        $language = $request->header('language', 'uz');

        $location->name = $location->getTranslatedAttribute("name", $language);
        $location->b_title = $location->getTranslatedAttribute("b_title", $language);
        $location->b_description = $location->getTranslatedAttribute("b_description", $language);

        foreach ($location->posts as &$item){
            $item->title=$item->getTranslatedAttribute("title", $language);
            $item->seo_title=$item->getTranslatedAttribute("seo_title", $language);
            $item->excerpt=$item->getTranslatedAttribute("excerpt", $language);
            $item->body=$item->getTranslatedAttribute("body", $language);
            $item->slug=$item->getTranslatedAttribute("slug", $language);
            $item->meta_description=$item->getTranslatedAttribute("meta_description", $language);
            $item->meta_keywords=$item->getTranslatedAttribute("meta_keywords", $language);
            $item->tags=$item->getTranslatedAttribute("tags", $language);
            unset($item->translations);
        }

        foreach ($location->communityEvents as &$item){
            $item->title=$item->getTranslatedAttribute("title", $language);
            $item->content=$item->getTranslatedAttribute("content", $language);
            unset($item->translations);
        }

        return $this->success($location);
    }
}
