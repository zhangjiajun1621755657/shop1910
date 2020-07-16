<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class YuekaoController extends Controller
{
    public function login(){
        $data = '问问';
        $method = 'AES-256-CBC';  //加密算法
        $key = '1910api';          //加密秘钥
        $iv = 'hellohelloabcabc'; //初始向量
        //加密数据
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        $sign = sha1($enc_data.$key);
        echo $sign;
    }
}
