<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;


/**
 * 用户单点登录
 * Class SsoMiddleware
 * @package App\Http\Middleware
 */
class SsoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!empty(session('admin.id'))) {
            $uid              = session('admin.id');
            $key              = "data|user|login" . $uid;
            $session_redis_id = Redis::get($key);
            $session_id       = Session::getId();
            if ($session_redis_id != $session_id) {
                return redirect('i');
            } else {
                return $next($request);
            }
        } else {
            return redirect('login');
        }
    }
}
