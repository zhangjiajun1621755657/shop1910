<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function a(){

        $request_uri = $_SERVER['REQUEST_URI'];
        $url_hash = substr(md5($request_uri),5,10);
        $expire = 10;  //限制十秒访问

        $key = 'access_total'.$url_hash;

        $total = Redis::get($key); //获取访问次数

        if($total>10){
            echo "请求过于频繁,请 $expire 秒稍后再试";
            //设置过期时间
            Redis::expire($key,$expire);
        }else{
            Redis::incr($key);
            echo "当前访问次数为:".$total;
        }

    }


    public function b(){
        $key = 'access_totalb';
        $total = Redis::incr($key);

        if($total>10){
            echo "请求过于频繁,请稍后再试";
        }else{
            echo "当前访问次数为:".$total;
        }
    }

    public function c(){
        $key = 'access_totalc';
        $total = Redis::incr($key);

        if($total>10){
            echo "请求过于频繁,请稍后再试";
        }else{
            echo "当前访问次数为:".$total;
        }
    }
}
