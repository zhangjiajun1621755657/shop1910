<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function a(){

        echo '访问方法a';

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
