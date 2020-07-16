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
        //echo '<pre>';print_r($_GET);echo '</pre>';
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

    /**
     * 请求接口
     */
    public function sendData(){
        $url = 'http://api.1910.com/test/receive?name=zhangsan&agr=22'; //要调用的接口
        $response = file_get_contents($url);
        echo $response;
    }

    /**
     * 向接口post数据
     */
    public function postData(){
        $key = 'secret';

        $data = [
            'user_name'=>'wangwu',
            'user_age'=>333
        ];

        $str = json_encode($data).$key;
        $sign = sha1($str);
        $send_data = [
            'data'=>json_encode($data),
            'sign'=>$sign
        ];

        $url = 'http://api.1910.com/test/receive-post';

        //通过post形式向接口发送数据

        //使用curl post数据

        //  1 实例化
        $ch = curl_init();

        //2  配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);  //使用post方式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$send_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //公国变量接收响应

        //3 开启会话(发送请求)
        $response = curl_exec($ch);


        //4 检测错误
        $errno = curl_errno($ch);
        $errmsg = curl_errno($ch);
        if($errno){
            var_dump($errmsg);die;
        }

        curl_close($ch);
        echo $response;
    }

    /**
     * 对称加密
     */

    public function encrypt1(){
        $data = '长江长江,我是黄河';
        $method = 'AES-256-CBC';  //加密算法
        $key = '1910api';          //加密秘钥
        $iv = 'hellohelloabcabc'; //初始向量
        //加密数据
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        $sign = sha1($enc_data.$key);

        $post_data = [
            'data'=>$enc_data,
            'sign'=>$sign
        ];

        //将密文发送到对端
        $url = 'http://api.1910.com/test/decrypt1';

        //初始化curl
         $ch = curl_init();

        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url); //post地址
        curl_setopt($ch,CURLOPT_POST,1);  //post方式发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data); //post的数据
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //公国变量接收响应

        //开启会话(发送请求)
       $response = curl_exec($ch); //接收响应
        echo $response;

        //捕捉错误
        $errno = curl_errno($ch);
        if($errno){
           $errmsg = curl_error($ch);
            var_dump($errmsg);die;
        }

         //关闭连接
        curl_close($ch);


    }

    /**
     * 非对称加密
     */
    public function rsaEncrypt1(){
        $data = "天王盖地虎";  //待加密数据
        //使用公钥加密
        $key_content = file_get_contents(storage_path('keys/pub.key')); //读取公钥内容
        $pub_key = openssl_get_publickey($key_content);
        openssl_public_encrypt($data,$enc_data,$pub_key);
        var_dump($enc_data);echo '<hr>';

        //将加密数据发送到对端进行解密

        //解密
        $key_content = file_get_contents(storage_path('keys/priv.key')); //获取私钥内容
        $priv_key = openssl_get_privatekey($key_content);
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        var_dump($dec_data);
    }

   public function sendB(){
       $data = '天王盖地虎';

       //公钥加密


       $key = openssl_get_publickey(file_get_contents(storage_path('keys/b_pub.key'))); //读取公钥
       openssl_public_encrypt($data,$enc_data,$key);

       //base64加密
       $base64_data = base64_encode($enc_data);

       $url = 'http://api.1910.com/get-a?data='.urlencode($base64_data);

       //接收响应
       $response = file_get_contents($url);
       //echo 'response:'.$response;
       $json_arr = json_decode($response,true);

       $enc_data =base64_decode($json_arr['data']); //密文

       //解密
       $key = openssl_get_privatekey(file_get_contents(storage_path('keys/a_priv.key')));
       openssl_private_decrypt($enc_data,$dec_data,$key);
       echo $dec_data;die;
   }

    public function rsaSign1(){
        $data = '天王盖地虎';
        //使用私钥签名
        $key = openssl_get_privatekey(file_get_contents(storage_path('keys/a_priv.key')));
        openssl_sign($data,$sign,$key);

       // $data = urlencode($data); //url参数处理
        $sign_str = urlencode(base64_encode($sign));

        $url = 'http://api.1910.com/rsa/verify1?data='.$data.'&sign='.$sign_str;

        $response = file_get_contents($url);
        echo $response;
    }

    public function encrypt(){
        $data = '问问';
        $method = 'AES-256-CBC';  //加密算法
        $key = '1910api';          //加密秘钥
        $iv = 'hellohelloabcabc'; //初始向量
        //加密数据
        $enc_data = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        $sign = sha1($enc_data.$key);
        echo $sign;
    }


    public function yanqian1(){
        $key = '1910';
        $data = 'hello word';
        $sign = sha1($data.$key);  //生成签名
        echo "要发送的数据:".$data;echo '</br>';
        echo "发送前生成的签名:".$sign; echo '<hr>';

        //将数据和签名发送到对端
        $b_url = 'http://www.1910.com/test/yanqian2?data='.$data.'&sign='.$sign;

        echo $b_url;
    }


    public function yanqian2(){
        $key = '1910';
        //echo '<pre>';print_r($_GET);echo '</pre>';
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
}
