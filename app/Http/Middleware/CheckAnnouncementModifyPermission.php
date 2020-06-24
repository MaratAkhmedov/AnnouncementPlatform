<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use App\Announcement;
use Illuminate\Support\Facades\Auth;

class CheckAnnouncementModifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($request->route()->parameter("id"));
        $announcement_id = $request->route()->parameter("id");
        if(Auth::id() == Announcement::getUserId($announcement_id)){
            return $next($request);
        }else{
            return response('Permission Denied.', 401);
        }
    }
}
