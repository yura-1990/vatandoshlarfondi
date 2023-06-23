<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\RequestBody;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[Prefix('media')]
#[PathItem]
class MediaController extends Controller
{

    /**
     * Create community
     */
    #[Post('/create')]
    public function createCommunity(Request $request): JsonResponse
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $folder = isset($request->folder) ? $request->folder : 'images';
            $path = $image->store($folder, 'public');

            return response()->json(['path' => $path], 200);
        }

        // If no file was uploaded, return an error response
        return response()->json(['error' => 'No image file uploaded'], 400);
    }

}
