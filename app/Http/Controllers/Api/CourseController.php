<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityRegionResource;
use App\Models\OnlineCourse\Course;
use App\Models\OnlineCourse\Lesson;
use App\Models\Public\Location;
use App\OpenApi\Responses\AllCommunityRegionResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('course')]
#[PathItem]
class CourseController extends Controller
{
    /**
     * Get all courses
     */
    #[Get('/courses')]
    #[Operation(tags: ['Courses'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAllCourses(Request $request): JsonResponse
    {
        $courses = Course::where('status', '>', 0)->orderBy('order', 'DESC')->get();
        return $this->success($courses);
    }
    /**
     * Get course by id
     */
    #[Get('/course/{id}')]
    #[Operation(tags: ['Courses'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getcourse(Request $request, $id): JsonResponse
    {
        $course = Course::where('status', '>', 0)->where('id', $id)->first();
        if (!$course){
            return response()->json(['error' => 'Not Found Courses'], 400);
        }
        return $this->success($course);
    }
    /**
     * Get lesson by id
     */
    #[Get('/lessons')]
    #[Operation(tags: ['Courses'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getlesson(Request $request): JsonResponse
    {
        if (!isset($request->course_id)){
            return response()->json(['error' => 'Required Course ID'], 400);
        }
        $course = Course::where('status', '>', 0)->where('id', $request->course_id)->first();
        if (!$course){
            return response()->json(['error' => 'Not Found Courses'], 400);
        }
        $lessons = Lesson::where('course_id', $course->id)->where('status', '>', 0)->get();
        return $this->success($lessons);
    }

}
