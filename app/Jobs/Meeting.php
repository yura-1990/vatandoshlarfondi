<?php

namespace App\Jobs;

use App\Models\Meeting\MeetingUser;
use App\Models\Notification\Notification;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class Meeting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            $currentDateTime = Carbon::now();

            $meetings = \App\Models\Meeting\Meeting::where('start_date', '>', $currentDateTime)
                ->get();
            $notifications = [];
            foreach ($meetings as $meeting) {
                $startDate = Carbon::parse($meeting->start_date);
                $remainingTime = $startDate->diff($currentDateTime);
                $meeting_users = MeetingUser::query()->where('meeting_id', $meeting->id)->pluck('user_id');
                if ($remainingTime->days == 3) {
                    $notifications[] = [
                        'meeting' => $meeting,
                        'users' => $meeting_users,
                        'duration' => 72
                    ];
                } elseif ($remainingTime->days === 1) {
                    $notifications[] = [
                        'meeting' => $meeting,
                        'users' => $meeting_users,
                        'duration' => 24
                    ];
                } elseif ($remainingTime->days === 0 && $remainingTime->h >= 1) {
                    $notifications[] = [
                        'users' => $meeting_users,
                        'meeting' => $meeting,
                        'duration' => 1
                    ];
                }
            }
            if (count($notifications) > 0) {
                foreach ($notifications as $notification) {
                    $not = Notification::query()->create(
                        [
                            "title" => $notification['meeting']->title,
                            "description" => $notification['meeting']->description,
                            "link" => $notification['meeting']->id,
                            "image" => $notification['meeting']->image,
                            "type" => 'event',
                            "user_id" => 1,
                        ]
                    );
                    $not->meeting = $notification['meeting'];
                    $not->duration = $notification['duration'];
                    $post = [];
                    $post['type'] = 'event';
                    $post['message'] = $not;
                    $post['users'] = $notification['users'];
                    $client = new Client();
                    $response = $client->post(env('SOCKET_HOST') . '/chat/send-message',
                        ['json' => $post]);
                }

            }
        }
        catch (\Exception $exception){
            dd($exception);
        }

    }
}
