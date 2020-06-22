<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    //redis测试
    public function redis1(){
        $key = 'name1';
        $val1 = Redis::get($key);
        var_dump($val1);echo'</br>';
        echo '$val1:'.$val1;
    }
}
