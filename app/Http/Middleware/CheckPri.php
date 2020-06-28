<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckPri
{
    /**
     * Handle an incoming request.
     *鉴权中间件
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('token');

        $uid = Redis::get($token);
        if(!$uid){
            $response = [
                'errno'=>50009,
                'msg'=>'鉴权失败'
            ];
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die;
        }

        return $next($request);
    }
}
