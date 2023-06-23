<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommunityRequest;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\MeetingUser;
use App\Models\Public\Location;
use App\Models\PublicAssociation\Community;
use App\Models\PublicAssociation\CommunityAttachment;
use App\Models\Userdata\UserProfile;
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

#[Prefix('meeting')]
#[PathItem]
class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all Meetings
     */
    #[Get('/meetings')]
    #[Operation(tags: ['Meeting'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAllMeeting(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $status = $request->is_end ?? 1;
        $type = $request->type ?? '';
        $page = $request->page ?? 1;
        $per_page = $request->per_page ?? 6;
        $webinars = Meeting::where('status', $status);
        if (strlen($type) > 0) {
            $webinars = $webinars->where('type', $type);
        }
        $count = $webinars->count();
        $webinars = $webinars->orderBy('created_at', 'desc')->forPage($page, $per_page)->get();
        foreach ($webinars as &$new) {
            $new->title = $new->getTranslatedAttribute("title", $language);
            $new->description = $new->getTranslatedAttribute("description", $language);
            unset($new->translations);
        }
        $old = Meeting::where('status', 0);
        $attendees = MeetingUser::whereIn('meeting_id', $old->pluck('id'))->count();
        return $this->success(["meetings" => $webinars, "count" => $count, "ended" => $old->count(), "attendees" => $attendees]);
    }

    /**
     * Get meeting by id
     */
    #[Get('/meeting/{id}')]
    #[Operation(tags: ['Meeting'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getMeeting(Request $request, $id): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $meeting = Meeting::where('id', $id)->with(['speakers'])->first();
        if (!$meeting) {
            return response()->json(['error' => 'Not Found Meeting or Meeting Ended'], 400);
        }
        $meeting->title = $meeting->getTranslatedAttribute("title", $language);
        $meeting->description = $meeting->getTranslatedAttribute("description", $language);
        $count = MeetingUser::query()->where('meeting_id', $meeting->id);
        $userIDS = $count->pluck('user_id');
        $count = $count->count();
        if ($count > 0 && $userIDS && count($userIDS)) {
            $locationIDS = UserProfile::whereIn('user_id', $userIDS)->pluck('international_location_id');
            $locations = Location::query()
                ->whereIn('id', $locationIDS)->get();
            foreach ($locations as &$location) {
                $location->count = MeetingUser::query()
                    ->leftJoin('user_profile', 'user_profile.user_id', '=', 'meeting_users.user_id')
                    ->where('meeting_users.meeting_id', $meeting->id)
                    ->where('user_profile.international_location_id', $location->id)
                    ->count();
            }
            $meeting->locations = $locations;
        } else {
            $meeting->locations = [];
        }

        $meeting->count = $count;
        unset($meeting->translations);
        return $this->success($meeting);
    }

    /**
     * Get all community Page info
     */
    #[Get('/page')]
    #[Operation(tags: ['Meeting'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getPage(Request $request): JsonResponse
    {
        $language = $request->header('language', 'uz');
        $page = Page::where('meta_keywords', 'meeting')->first();
        if ($page) {
            $oldMeetings = Meeting::query()->where('status', '=', 0);
            $page->title = $page->getTranslatedAttribute("title", $language);
            $page->body = $page->getTranslatedAttribute("body", $language);
            $page->end_count = $oldMeetings->count();
            $members = MeetingUser::query()->whereIn('meeting_id', $oldMeetings->pluck('id'));
            $page->members = $members->count();
            $locationIDS = UserProfile::whereIn('user_id', $members->pluck('user_id'))->pluck('international_location_id');
            if (count($locationIDS)){
                $locations = Location::query()
                    ->whereIn('id', $locationIDS)->get();
                foreach ($locations as &$location) {
                    $location->count = MeetingUser::query()
                        ->leftJoin('user_profile', 'user_profile.user_id', '=', 'meeting_users.user_id')
                        ->leftJoin('meetings', 'meetings.id', '=', 'meeting_users.meeting_id')
                        ->where('user_profile.international_location_id', $location->id)
                        ->whereIn('meetings.id', $oldMeetings->pluck('id'))
                        ->count();
                }
                $page->locations = collect($locations)->sortBy(function ($object) {
                    return $object['count'];
                })->values()->all();
            }else{
                $page->locations = [];
            }

        }
        return $this->success($page);
    }

    /**
     * Create community
     **/
    #[Post('/create/{id}')]
    #[Operation(tags: ['Meeting'], security: BearerTokenSecurityScheme::class, method: 'POST')]
    public function createMeetingRequest(Request $request, $id): JsonResponse
    {
        $meeting = Meeting::where('status', '>', 0)->where('id', $id)->first();
        if (!$meeting) {
            return response()->json(['error' => 'Not Found Meeting'], 400);
        }
        $user_id = auth()->guard('api')->id();
        $meetingRequest = MeetingUser::where('meeting_id', $id)->where('user_id', $user_id)->first();
        if ($meetingRequest) {
            return $this->success(['msg' => 'Allready requested']);
        } else {
            MeetingUser::query()->create(
                [
                    'user_id' => $user_id,
                    'meeting_id' => $id,
                ]
            );
            return $this->success(['msg' => 'Success']);

        }
    }

}
