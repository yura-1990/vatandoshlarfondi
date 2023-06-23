<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommunityRequest;
use App\Models\Meeting\Meeting;
use App\Models\Meeting\MeetingUser;
use App\Models\Notification\Notification;
use App\Models\Notification\NotificationUser;
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
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use TCG\Voyager\Models\Page;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('notification')]
#[PathItem]
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all Meetings
     */
    #[Get('/notification')]
    #[Operation(tags: ['Notification'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getAllMeeting(Request $request): JsonResponse
    {
        $user_id = auth()->guard('api')->id();
        $per_page = $request->per_page ?? 6;
        $notifications = Notification::query()
            ->leftJoin('notification_users', 'notification_users.notification_id', '=', 'notifications.id')
//            ->where('notification_users.user_id', $user_id)
            ->select(['notifications.*', 'notification_users.is_read'])
            ->orderBy('notifications.created_at', 'desc');
        $notifications = $notifications->paginate($per_page);
        foreach ($notifications as &$notification) {
            if ($notification->type === 'event'){
                $notification->meeting = Meeting::query()->where('id', $notification->link)->first();
            }
        }
        return $this->success(['notifications' =>$notifications]);
    }

    /**
     * Get meeting by id
     */
    #[Get('/notification/{id}')]
    #[Operation(tags: ['Notification'], security: BearerTokenSecurityScheme::class, method: 'GET')]
    public function getMeeting(Request $request, $id): JsonResponse
    {
        $user_id = auth()->guard('api')->id();
        $notification = Notification::query()
            ->where('id', $id)->first();
        if ($notification){
            NotificationUser::updateOrCreate(
                    [
                        'user_id'=> $user_id,
                        'notification_id'=> $notification->id,
                    ],
                    ['is_read'=>true],

                );
            $nuser = NotificationUser::query()
                ->where('user_id',$user_id)
                ->where('notification_id',$notification->id)
                ->first();
            if ($nuser){
                $nuser->is_read = true;
                $nuser->save();
            }else{
                $nuser = NotificationUser::query()->insert(
                    [
                        'user_id'=> $user_id,
                        'notification_id'=> $notification->id,
                        'is_read'=>true
                    ]

                );
            }
            $notification->is_read = true;
            return $this->success($notification);
        }else{
            return response()->json(['error' => 'Not Found Notifications'], 400);

        }
    }


}
