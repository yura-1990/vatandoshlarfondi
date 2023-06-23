<?php

namespace App\Http\Controllers\Api;


use App\Models\Notification\Notification;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use http\Env;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Controller;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class NewVoyagerController extends BaseVoyagerBaseController
{
    use BreadRelationshipParser;

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
        $notification = Notification::query()->create(
            [
                "title"=>$request->title,
                "description"=>$request->body,
                "image"=>json_encode($data->image),
                "link"=>$data->id,
                "type"=>'new',
                "user_id"=>Auth::user()->id,
            ]
        );
        $users = User::query()->pluck('id');
        $notification->image = json_decode($notification->image);
        $post = [];
        $post['type'] = 'new';
        $post['message'] = $notification;
        $post['users'] = $users;
        $client = new Client();
        $response = $client->post(env('SOCKET_HOST') . '/chat/send-message',
            ['json' => $post]);
        event(new BreadDataAdded($dataType, $data));

        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

}
