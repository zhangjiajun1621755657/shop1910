<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\Redis;
class IndexController extends Controller
{
    //注册视图
    public function reg(){
        return view('user.reg');
    }

    /**
     * 注册用户
     * @param Request $request
     */
    public function regDo(Request $request){
        $pass1 = $request->input('password');
        $pass2 = $request->input('password2');
        $name = $request->input('user_name');
        $email = $request->input('email');

        //密码长度是否大于6
        $len = strlen($pass1);
        if($len<6){
            die('密码长度必须大于6位数');
        }

//        if($pass1=$pass2){
//            die('两次密码输入不一致');
//        }

        $name1 = UserModel::where(['user_name'=>$name])->first();
        if($name1){
           die('该用户名已存在');
        }

        if(empty($name)){
            die('名称必填');
        }
        if(empty($email)){
            die('邮箱必填');
        }

        //生成密码
        $pass = password_hash($pass1,PASSWORD_BCRYPT);
        $data = [
            'user_name'=>$name,
            'email'=> $email,
            'password'=>$pass,
            'reg_time'=>time()
        ];
        $res = UserModel::insert($data);
        if($res){
            echo '注册成功';
        }else{
            echo '注册失败';
        }
    }

    /**
     * 用户登录视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
      return view('user.login');
    }

    /**
     * 执行登录
     */
    public function loginDo(Request $request){
       $name = $request->input('name');
       $pass = $request->input('password');
       //echo '用户输入的密码:'.$pass;echo '<br>';

        //验证登录信息
        $u = UserModel::where(['user_name'=>$name])->first();
        //echo '数据库的密码:'.$u->password;echo '<br>';

        //验证密码
        $res = password_verify($pass,$u->password);
        if($res){
            header('Refresh:2;url=/user/center');
            echo '登录成功';
        }else{
            echo '用户名与密码不一致,请重新登录';
            header('Refresh:2;url=/user/login');
        }
    }

    public function center(){
        return view('user.center');
    }

}
