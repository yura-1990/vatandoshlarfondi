<?php

use CloudCreativity\LaravelJsonApi\Routing\Route;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Route::group(['middleware' => ['api']], function () {
    Broadcast::channel('app', function ($user, $id) {
        return true;
        return (int) $user->id === (int) $id;
    });
});
Broadcast::channel('chat', function ($user, $id) {

    return false;
    return (int) $user->id === (int) $id;
});
