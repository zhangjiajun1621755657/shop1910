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

    public function test1(){
        $data = [
            'name'=>'zhangsan',
            'email'=>'zhangsan@qq.com'
        ];
        return $data;
    }


    /**
     * 发送数据
     */
    public function sign1(){
        $key = '1910';
        $data = 'hello word';
        $sign = sha1($data.$key);  //生成签名
        echo "要发送的数据:".$data;echo '</br>';
        echo "发送前生成的签名:".$sign; echo '<hr>';

        //将数据和签名发送到对端
        $b_url = 'http://www.1910.com/secret?data='.$data.'&sign='.$sign;

        echo $b_url;
    }

    /**
     * 接收数据
     */
    public function secret(){
        $key = '1910';
        echo '<pre>';print_r($_GET);echo '</pre>';
        //收到数据 验证签名
        $data = $_GET['data']; //收到的数据
        $sign = $_GET['sign']; //接收到的签名
        $local_sign = sha1($data.$key);
        echo '本地计算的签名:'.$local_sign;echo '</br>';
        if($sign == $local_sign){
            echo '验证通过';
        }else{
            echo '验证失败';
        }
    }


    public function www(){

        $key = '1910';

        //接口地址
        $url = 'http://api.1910.com/api/info';

        //向接口发送数据

        //get方式发送
        $data = 'hello';
        $sign = sha1($data.$key);
        $url = $url.'?data='.$data.'&sign='.$sign;


        //php 发起网络请求
        $response = file_get_contents($url);
        echo $response;



    }

}
