<?php

namespace App\Http\Middleware;

use Closure;
//use App\Models\OperateLog;
use Illuminate\Support\Facades\DB;
class AdminOperationLog
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
//        $input   = $request->all();
//        $log     = DB::connection('backTest');
//        $addData = [];
//        $uid = session('admin.id');
//        $addData['uid']         = $uid;
//        $addData['username']    = session('admin.username');
//        $addData['path']        = $request->path();
//        $addData['method']      = $request->method();
//        $addData['ip']          = ip2long($request->ip());
//        $addData['input']       = json_encode($input, JSON_UNESCAPED_UNICODE);
//        $addData['sql']         = '';
//        $log->table('operate_log')->insertGetId($addData);
        return $next($request);
    }


}
