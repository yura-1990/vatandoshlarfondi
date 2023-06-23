<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use http\Env;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Controller;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class MeetingVoyagerController extends BaseVoyagerBaseController
{
    use BreadRelationshipParser;

    private function base64UrlEncode($data)
    {
        $base64 = base64_encode($data);
        $base64Url = strtr($base64, '+/', '-_');
        return rtrim($base64Url, '=');
    }

    //function to generate JWT
    private function generateJWTKey()
    {
        $key = \env('API_KEY_ZOOM');
        $secret = \env('API_SEC_ZOOM');
        $payload = array(
            'iss' => $key,
            'exp' => time() + 60 // Set the expiration time for the token (in seconds)
        );

        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        );
        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }


    private function sendRequest($name, $date)
    {
        //Enter_Your_Email {user_email}
        $request_url = "https://api.zoom.us/v2/users/me/meetings";
        $formatted_date = Carbon::createFromFormat('m/d/Y h:i A', $date)->format('Y-m-d, H:i:s');
        $data = [
            "topic" => $name,
            "type" => 2,
            "start_time" => $formatted_date,
            "duration" => "45",
            "timezone" => "Asia/Tashkent",
            "agenda" => "test",

            "recurrence" => ["type" => 1,
                "repeat_interval" => 1
            ],
            "settings" => ["host_video" => "true",
                "participant_video" => "true",
                "join_before_host" => "False",
                "mute_upon_entry" => "False",
                "watermark" => "true",
                "audio" => "voip",
                "auto_recording" => "cloud"
            ]
        ];
        $headers = array(
            "authorization: Bearer " . $this->generateJWTKey(),
            "content-type: application/json",
            "Accept: application/json",
        );

        $postFields = json_encode($data);

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$response) {
            return $err;
        }
        return json_decode($response);
    }

    public function getAttendees($meetingUUID)
    {
        try {
            $token = $this->generateJWTKey();
//        "https://api.zoom.us/report/meetings/{$meetingUUID}/participants"
            $client = new Client();
            $response = $client->request('GET', "https://api.zoom.us/v2/metrics/meetings" , [
                'headers' => [
                    'Authorization' => "Bearer $token",
                    'Content-Type' => 'application/json',
                ],
            ]);

            $attendeeCount = json_decode($response->getBody())->total_records;

            return $attendeeCount;
        }catch (\Exception $exception){
            return [];
        }


        function generateJWTToken($apiKey, $apiSecret)
        {
            $payload = array(
                'iss' => $apiKey,
                'exp' => time() + 3600, // Expiry time in seconds (1 hour)
            );

            return JWT::encode($payload, $apiSecret, 'HS256');
        }
    }

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
        $zoom = $this->sendRequest($request->title, $request->start_date);
        $request->merge(['url' => $zoom->join_url, 'uuid' => $zoom->uuid]);
        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

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



    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable'));
    }


    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $uuid = $this->getAttendees($request->uuid);
        $request->merge(['attendees' => count($uuid)]);
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        $query = $model->query();
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $query = $query->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query = $query->withTrashed();
        }

        $data = $query->findOrFail($id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();

        // Get fields with images to remove before updating and make a copy of $data
        $to_remove = $dataType->editRows->where('type', 'image')
            ->filter(function ($item, $key) use ($request) {
                return $request->hasFile($item->field);
            });
        $original_data = clone($data);

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        // Delete Images
        $this->deleteBreadImages($original_data, $to_remove);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message' => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }


}
