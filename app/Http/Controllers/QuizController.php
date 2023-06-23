<?php

namespace App\Http\Controllers;

use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizParticipant;
use App\OpenApi\Parameters\QuizParameters;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;

#[Prefix('quiz-list')]
#[PathItem]
class QuizController extends Controller
{
    /**
     * Get all quizzes
     */
    #[Get('/quizzes')]
    #[Operation(tags: ['Quizzes'], method: 'GET')]
    #[Parameters(factory: QuizParameters::class)]
    public function getAllQuizzes(Request $request): JsonResponse
    {
        $status = $request->status ?? 1;
        $year = $request->year ?? 0;
        $language = $request->header('language', 'uz');
        $paginate = $request->query('paginate', 6);
        $now = Carbon::now();
        $quizzes = Quiz::query()->where('status', $status);
        if ($year > 0) {
            $quizzes = $quizzes->WhereYear('started_at', $year);
        }
        $quizzes = $quizzes->orderBy('finished_at', 'DESC')->paginate($paginate);
        foreach ($quizzes as &$new) {
            $new->title = $new->getTranslatedAttribute("title", $language);
            $new->description = $new->getTranslatedAttribute("description", $language);
            $new->image = json_decode($new->image);
            unset($new->translations);
        }
        $participants = QuizParticipant::where('position', '=', 1)->with(['user', 'quiz'])->get();
        return $this->success($quizzes);
    }

    /**
     * Get quiz by id
     */
    #[Get('/quiz/{id}')]
    #[Operation(tags: ['Quizzes'], method: 'GET')]
    public function getquiz(Request $request, $id): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $quiz = Quiz::query()->with(['participants', 'questions'])->where('id', $id)->first();
        if (!$quiz) {
            return response()->json(['error' => 'Not Found Quiz'], 400);
        }
        $quiz->title = $quiz->getTranslatedAttribute("title", $language);
        $quiz->description = $quiz->getTranslatedAttribute("description", $language);
        $quiz->image = json_decode($quiz->image);
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

}
