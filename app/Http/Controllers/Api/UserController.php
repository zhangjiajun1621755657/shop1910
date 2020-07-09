<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\TokenModel;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    //注册视图
    public function reg1(){
        return view('user.reg');
    }

    /**
     * 注册用户
     * @param Request $request
     */
    public function reg(Request $request){

        $pass1 = $request->input('password');

        $pass2 = $request->input('password2');
        $name = $request->input('user_name');
        $email = $request->input('email');

        //密码长度是否大于6
        $len = strlen($pass1);
        if($len<6){
           $response = [
               'errno'=>50001,
               'msg'=>"密码长度必须大于6位"
           ];
            return $response;
        }

        if($pass1!=$pass2){
            $response = [
                'errno'=>50002,
                'msg'=>"两次密码输入不一致"
            ];
            return $response;
        }

        $name1 = UserModel::where(['user_name'=>$name])->first();
        if($name1){
            $response = [
                'errno'=>50003,
                'msg'=>"用户名已存在"
            ];
            return $response;
        }

        $u = UserModel::where('email',$email)->first();
        if($u){
            $response = [
                'errno'=>50004,
                'msg'=>"email已经存在"
            ];
            return $response;
        }

        //生成密码
        $pass = password_hash($pass1,PASSWORD_BCRYPT);
        //var_dump($pass);die;
        $data = [
            'user_name'=>$name,
            'email'=> $email,
            'password'=>$pass,
            'reg_time'=>time()
        ];
        $res = UserModel::insert($data);
        if($res){
            $response = [
                'errno'=>50000,
                'msg'=>"注册成功"
            ];
            return $response;
        }else{
            $response = [
                'errno'=>50005,
                'msg'=>"注册失败"
            ];
            return $response;
        }
    }


    /**
     * 执行登录
     */
    public function login(Request $request){
        $name = $request->input('name');
        $pass = $request->input('password');

        //验证登录信息
        $u = UserModel::where(['user_name'=>$name])->first();


        //验证密码
        $res = password_verify($pass,$u->password);
        if($res){

            //生成token
            $str = $u->user_id . $u->user_name . time();
            $token = substr(md5($str),10,16);

            //将token保存在redis中
            Redis::set($token,$u->user_id);

            $response = [
                'errno'=>0,
                'msg'=>'ok',
                'token'=>$token
            ];
        }else{
            $response = [
                'errno'=>50006,
                'msg'=>'ok',
                'token'=>'用户名与密码不一致,请重新登录'
            ];
        }
        return $response;
    }

    public function center(Request $request){
        $token = $request->input('token');
        //验证token是否有效
        $uid = Redis::get($token);
        if($uid){

            $user_info = UserModel::find($uid);
            echo $user_info->user_name .  '欢迎来到个人中心!';
        }else{
            $response = [
                'errno'=>50008,
                'msg'=>'请先登录'
            ];
            return $response;
        }

    }

    public function orders(){
        $arr = [
            '0987657890621123',
            '0984567890621123',
            '0987654568621123',
            '0987657890121123'
        ];

        $response = [
            'errno'=>0,
            'msg'=>'ok',
            'data'=>[
                'oredrs'=>$arr
            ]
        ];
        return $response;
    }

    public function cart(){
        $goods = [
            123,
            456,
            789
        ];

        $response = [
            'errno'=>0,
            'msg'=>'ok',
            'data'=>$goods
        ];

        return $response;
    }
}
