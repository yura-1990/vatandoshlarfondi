<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EBooks\ELibrary;
use App\Models\EBooks\LibrarySlider;
use App\Models\Public\PostsTag;
use App\Models\Public\PostTag;
use App\OpenApi\Parameters\ELibraryPaginateParameters;
use App\OpenApi\Parameters\ELibraryParameters;
use App\OpenApi\Responses\ELibraryResponse;
use App\OpenApi\Responses\LibrarySliderResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('ebook')]
#[PathItem]
class ELibraryController extends Controller
{
    /**
     * get all e-books
     */
    #[Get('/filter-all-books/{paginate}')]
    #[Operation(tags: ['ELibrary'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ELibraryPaginateParameters::class)]
    #[Response(factory: ELibraryResponse::class)]
    public function getFilteredEBooks(Request $request, $paginate = 16): JsonResponse
    {
        $language = $request->header('language', 'uz');

        $search = $request->get('search') ?? null;
        $languages = $request->get('lang') ?? null;
        $type = $request->get('type') ?? null;
        $new = $request->get('new') ?? null;
        $popular = $request->get('popular') ?? null;

        $columns = ['title', 'stars', 'author', 'publication', 'ages', 'stir'];

        if ($search && $languages && $type){

            $ebooks = ELibrary::search($columns, $search);

            if ($new){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('type', $type)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }
            elseif ($popular){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('type', $type)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('language',$languages)
                ->where('type', $type)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);

        }
        elseif ($search && $languages){

            $ebooks = ELibrary::search($columns,$search);

            if ($new){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }elseif ($popular){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('language',$languages)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);
        }
        elseif ($search && $type){

            $ebooks = ELibrary::search($columns,$search);

            if ($new){
                $books = $ebooks
                    ->where('type', $type)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }elseif ($popular){
                $books = $ebooks
                    ->where('type', $type)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('type', $type)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);

        }
        elseif ($languages && $type){

            $ebooks = ELibrary::query();

            if ($new) {
                $books = $ebooks
                    ->where('language', $languages)
                    ->where('type', $type)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            } elseif ($popular){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('type', $type)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('language', $languages)
                ->where('type', $type)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);
        }
        elseif($search){

            $ebooks = ELibrary::search($columns, $search);

            if ($new){
                $books = $ebooks
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            } elseif ($popular){
                $books = $ebooks
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);
        }
        elseif($languages){

            $ebooks = ELibrary::query();

            if ($new){
                $books = $ebooks
                    ->where('language', $languages)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            } elseif ($popular){
                $books = $ebooks
                    ->where('language',$languages)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('language', $languages)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);
        }
        elseif($type){

            $ebooks = ELibrary::query();

            if ($new){
                $books = $ebooks
                    ->where('type', $type)
                    ->where('viewers', '<', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }elseif ($popular){
                $books = $ebooks
                    ->where('type', $type)
                    ->where('viewers', '>', 50)
                    ->paginate($paginate);

                foreach ($books as &$book) {
                    $book->title = $book->getTranslatedAttribute("title", $language);
                    $book->text = $book->getTranslatedAttribute("text", $language);
                    $book->type = $book->getTranslatedAttribute("type", $language);
                    unset($book->translations);
                }

                return $this->success($books);
            }

            $books = $ebooks
                ->where('type', $type)
                ->paginate($paginate);

            foreach ($books as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($books);
        }
        elseif($new){
            $ebooks = ELibrary::query()
                ->where('viewers', '<', 50)
                ->paginate($paginate);

            foreach ($ebooks as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($ebooks);


        }
        elseif ($popular){
            $ebooks = ELibrary::query()
                ->where('viewers', '>', 50)
                ->paginate($paginate);

            foreach ($ebooks as &$book) {
                $book->title = $book->getTranslatedAttribute("title", $language);
                $book->text = $book->getTranslatedAttribute("text", $language);
                $book->type = $book->getTranslatedAttribute("type", $language);
                unset($book->translations);
            }

            return $this->success($ebooks);
        }

        $ebooks = ELibrary::query()->paginate($paginate);

        foreach ($ebooks as &$book) {
            $book->title = $book->getTranslatedAttribute("title", $language);
            $book->text = $book->getTranslatedAttribute("text", $language);
            $book->type = $book->getTranslatedAttribute("type", $language);
            unset($book->translations);
        }

        return $this->success($ebooks);
    }

    /**
     * get one e-book
     */
    #[Get('/get-one/{ELibrary}')]
    #[Operation(tags: ['ELibrary'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ELibraryParameters::class)]
    #[Response(factory: ELibraryResponse::class)]
    public function getOneEBook(Request $request, ELibrary $ELibrary): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $ELibrary->viewers += 1;
        $ELibrary->save();

        $ELibrary->title = $ELibrary->getTranslatedAttribute("title", $language);
        $ELibrary->text = $ELibrary->getTranslatedAttribute("text", $language);
        $ELibrary->type = $ELibrary->getTranslatedAttribute("type", $language);
        $ELibrary->format = $ELibrary->getTranslatedAttribute("format", $language);
        unset($ELibrary->translations);

        return $this->success($ELibrary);

    }

    /**
     * get all new e-books
     */
    #[Get('/get-new-book/{paginate}')]
    #[Operation(tags: ['ELibrary'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ELibraryPaginateParameters::class)]
    #[Response(factory: ELibraryResponse::class)]
    public function newEBooks(Request $request, $paginate=12): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $newEBooks = ELibrary::query()
            ->where('viewers','<', 50)
            ->orderByDesc('created_at')->paginate($paginate);

        foreach ($newEBooks as $book){
            $book->title = $book->getTranslatedAttribute("title", $language);
            $book->text = $book->getTranslatedAttribute("text", $language);
            $book->type = $book->getTranslatedAttribute("type", $language);
            $book->format = $book->getTranslatedAttribute("format", $language);
            unset($book->translations);
        }

        return $this->success($newEBooks);
    }

    /**
     * get all popular e-books
     */
    #[Get('/get-popular-book/{paginate}')]
    #[Operation(tags: ['ELibrary'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Parameters(factory: ELibraryPaginateParameters::class)]
    #[Response(factory: ELibraryResponse::class)]
    public function popularEBooks(Request $request, $paginate=12): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $newEBooks = ELibrary::query()
            ->where('viewers','>', 50)
            ->orderByDesc('created_at')->paginate($paginate);

        foreach ($newEBooks as $book){
            $book->title = $book->getTranslatedAttribute("title", $language);
            $book->text = $book->getTranslatedAttribute("text", $language);
            $book->type = $book->getTranslatedAttribute("type", $language);
            $book->format = $book->getTranslatedAttribute("format", $language);
            unset($book->translations);
        }

        return $this->success($newEBooks);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Get('/all-slider-images')]
    #[Operation(tags: ['ELibrary'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: LibrarySliderResponse::class)]
    public function getLibrarySliderData(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $librarySliders = LibrarySlider::query()->get();

        foreach ($librarySliders as $librarySlider){
            $librarySlider->title = $librarySlider->getTranslatedAttribute("title", $language);
            $librarySlider->text = $librarySlider->getTranslatedAttribute("text", $language);
            unset($librarySlider->translations);
        }

        return $this->success($librarySliders);

    }
}
