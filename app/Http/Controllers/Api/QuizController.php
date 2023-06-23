<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Public\Location;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizAnswer;
use App\Models\Quiz\QuizParticipant;
use App\Models\Quiz\QuizParticipantImage;
use App\Models\Quiz\QuizQuestion;
use App\Models\Userdata\UserProfile;
use App\OpenApi\Responses\AllCommunityNewResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Page;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;
#[Prefix('quiz')]
#[PathItem]
class QuizController extends Controller
{
    /**
     * Get all quizzes
     */
    #[Get('/quizzes')]
    #[Operation(tags: ['Quizzes'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAllQuizzes(Request $request): JsonResponse
    {
        $user_id = auth()->guard('api')->id();
        $status = $request->status ?? 1;
        $year = $request->year ?? 0;
        $language = $request->header('language', 'uz');
        $now = Carbon::now();
        $quizzes = Quiz::orderBy('quizzes.finished_at', 'DESC');
        if (isset($request->status)){
            $quizzes = $quizzes->where('quizzes.status', $status);
        }
        if (isset($request->is_me)){
            $quizzes = $quizzes
                ->leftJoin('quiz_participants', 'quiz_participants.quiz_id', '=','quizzes.id')
                ->select(['quizzes.*', 'quiz_participants.user_id', 'quiz_participants.position'])
                ->where('quiz_participants.user_id', $user_id);
        }
        if ($year > 0) {
            $quizzes = $quizzes->WhereYear('quizzes.started_at', $year);
        }
        $quizzes = $quizzes
//            ->groupBy('quizzes.id')
//            ->distinct('quizzes.id')
            ->get();
        foreach ($quizzes as &$new) {
            $new->title = $new->getTranslatedAttribute("title", $language);
            $new->description = $new->getTranslatedAttribute("description", $language);
            unset($new->translations);
        }
        $participants = QuizParticipant::query()->where('position', '=', 1)->with(['user', 'quiz'])->get();
        return $this->success(["quizzes" => $quizzes, "participants" => $participants]);
    }

    /**
     * Get quiz by id
     */
    #[Get('/quiz/{id}')]
    #[Operation(tags: ['Quizzes'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getquiz(Request $request, $id): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $quiz = Quiz::query()->with(['participants', 'questions'])->where('id', $id)->first();
        if (!$quiz) {
            return response()->json(['error' => 'Not Found Quiz'], 400);
        }
        $quiz->title = $quiz->getTranslatedAttribute("title", $language);
        $quiz->description = $quiz->getTranslatedAttribute("description", $language);
        unset($quiz->translations);
        if (isset($quiz->questions) && count($quiz->questions) > 0) {
            foreach ($quiz->questions as &$new) {
                $new->question = $new->getTranslatedAttribute("question", $language);
                if (isset($quiz->questions->answers) && count($quiz->questions->answers) > 0) {
                    foreach ($quiz->questions->answers as &$answer) {
                        $answer->answer = $new->getTranslatedAttribute("answer", $language);
                        unset($answer->translations);
                    }
                }
                unset($new->translations);
            }
        }
        return $this->success($quiz);
    }


    /**
     * Get all community Page info
     */
    #[Get('/page')]
    #[Operation(tags: ['Quizzes'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    #[Response(factory: AllCommunityNewResponse::class)]
    public function getPage(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $users = QuizParticipant::query()->select('user_id')
            ->groupBy('user_id');
        $page = Page::where('meta_keywords', 'quizzes')->first();
        if ($page) {
            $page->title = $page->getTranslatedAttribute("title", $language);
            $page->body = $page->getTranslatedAttribute("body", $language);
            $page->count = $users->count();
            $locationIDS = UserProfile::whereIn('user_id', $users->pluck('user_id'))->pluck('international_location_id');
            $locations = Location::query()
                ->whereIn('id', $locationIDS)->get();
            foreach ($locations as &$location) {
                $location->count = QuizParticipant::query()
                    ->leftJoin('user_profile', 'user_profile.user_id', '=', 'quiz_participants.user_id')
                    ->where('user_profile.international_location_id', $location->id)
                    ->count();
            }
            $page->locations = collect($locations)->sortBy(function ($object) {
                return $object['count'];
            })->values()->all();
        }
        return $this->success($page);
    }

    /**
     * Create community
     */
    #[\Spatie\RouteAttributes\Attributes\Post('/participant/{id}')]
    public function createQuiz(Request $request, $id): JsonResponse
    {
        $user_id = auth()->guard('api')->id();
        if (isset($request->passport) || isset($request->fio)) {
            $profile = UserProfile::query()->where('user_id', $user_id)->first();
            if ($profile) {
                if (isset($request->passport)) {
                    $profile->passport_file = $request->passport;
                }
                if (isset($request->fio)) {
                    $fios = explode(" ", $request->fio);
                    if (isset($fios[0])) {
                        $profile->first_name = $fios[0];
                    }
                    if (isset($fios[1])) {
                        $profile->second_name = $fios[1];
                    }
                    if (isset($fios[2])) {
                        $profile->last_name = $fios[2];
                    }
                }
            }
        }
        $quiz = Quiz::where('status', '>', 0)->where('id', $id)->first();
        if (!$quiz) {
            return response()->json(['error' => 'Not Found Quiz'], 400);
        }
        if ($quiz->type == 'images') {
            $participant = QuizParticipant::where('quiz_id', $quiz->id)->where('user_id', $user_id)->first();

            if (!$participant) {
                $participant = QuizParticipant::query()->create(
                    [
                        'user_id' => $user_id,
                        'quiz_id' => $quiz->id
                    ]

                );
            }

            if (isset($request->images)) {
                $images = [];
                foreach ($request->images as $image) {
                    $images[] = [
                        'quiz_participant_id' => $participant->id,
                        'image' => $image
                    ];
                }
                if (count($images) > 0) {
                    QuizParticipantImage::insert(
                        $images
                    );
                    return $this->success(['message' => 'Success']);

                }
            }


        } elseif ($quiz->type == 'video') {
            $participant = QuizParticipant::where('quiz_id', $quiz->id)->where('user_id', $user_id)->first();

            if (!$participant) {
                $participant = QuizParticipant::query()->create(
                    [
                        'user_id' => $user_id,
                        'quiz_id' => $quiz->id,
                        'link' => $request->link
                    ]

                );
                return $this->success(['message' => 'Success']);
            }
        } elseif ($quiz->type == 'text') {
            $participant = QuizParticipant::where('quiz_id', $quiz->id)->where('user_id', $user_id)->first();
            if ($request->hasFile('text')) {
                $text = $request->file('text');
                $folder = isset($request->folder) ? $request->folder : 'text';
                $path = $text->store($folder, 'public');
            } else {
                return response()->json(['error' => 'Not Found Text'], 400);
            }
            if (!$participant) {

                $participant = QuizParticipant::query()->create(
                    [
                        'user_id' => $user_id,
                        'quiz_id' => $quiz->id,
                        'doc' => $path,
                    ]

                );
            }
            $participant->doc = $path;
            $participant->save();
            return $this->success(['message' => 'Success']);
        } elseif ($quiz->type == 'test') {
            $participant = QuizParticipant::where('quiz_id', $quiz->id)->where('user_id', $user_id)->first();
            if (isset($request->answers)) {
                $answers = $request->answers;
                $all = 0;
                foreach ($answers as $keyAnswer => $answer) {
                    $question = QuizQuestion::where('id', $keyAnswer)->where('quiz_id', $quiz->id)
                        ->first();
                    if ($question) {
                        $ansRight = QuizAnswer::where('id', $answer)->where('quiz_question_id', $question->id)
                            ->first();
                        if ($ansRight) {
                            if ($ansRight->is_correct) {
                                $all = $all + 1;
                            }
                        }
                    } else {
                        return response()->json(['error' => 'Not Found Question'], 400);
                    }
                }
            } else {
                return response()->json(['error' => 'Not Found Text'], 400);
            }
            if (!$participant) {

                $participant = QuizParticipant::query()->create(
                    [
                        'user_id' => $user_id,
                        'quiz_id' => $quiz->id,
                        'question' => $all,
                    ]

                );
            } else {
                $participant->question = $all;
                $participant->save();
            }
            return $this->success(['message' => 'Success']);
        }

        return $this->success($quiz);
    }


}
