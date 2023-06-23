<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use DB;

class LastOnlineAt
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('api')->check() && Carbon::parse(auth('api')->user()->last_online_at)->diffInMinutes(now()) > 3) {
            DB::table("users")
                ->where("id", auth('api')->user()->id)
                ->update(["last_online_at" => now()]);
        }
        return $next($request);
    }
}
