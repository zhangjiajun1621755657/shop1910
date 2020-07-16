<?php

namespace App\Http\Controllers\Cs;

use App\Http\Controllers\Controller;
use App\Model\CsModel;
use App\TokenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    //注册视图
     public function zc(){
         return view('cs.zc');
     }

    //实现注册
    public function zc2(Request $request){
      $user_name = $request->input(['user_name']);
      $email = $request->input(['user_email']);
      $tel = $request->input(['tel']);
      $gs_name = $request->input(['gs_name']);
      $gs_dizhi =$request->input(['gs_dizhi']);
      $pass1 = $request->input(['user_pwd']);
      $pass2 = $request->input(['user_pwd2']);

        $u_name = CsModel::where(['user_name'=>$user_name])->first();
        if($u_name){
            echo '用户名已存在';die;
        }

        if($pass1<6){
            echo '密码长度大于六位';die;
        }

        if($pass1!=$pass2){
            echo '两次密码输入不一致';die;
        }

        //生成密码token
        $pass = password_hash($pass1,PASSWORD_BCRYPT);
        $data = [
            'user_name'=>$user_name,
            'user_email'=>$email,
            'tel'=>$tel,
            'gs_name'=>$gs_name,
            'gs_dizhi'=>$gs_dizhi,
            'user_pwd'=>$pass
        ];

        $res = CsModel::create($data);
        if($res){
          echo '注册成功';
        }else{
          echo '注册失败';
        }
    }


    public function login(){
        return view('cs.login');
    }

    public function loginDo(Request $request){
      $user_name = $request->input(['user_name']);
      $user_pwd = $request->input(['user_pwd']);
      $data = CsModel::where(['user_name'=>$user_name])->first();

        //验证密码
        $res = password_verify($user_pwd,$data->user_pwd);
      if($res){
          $str = $data->user_id . $data->user_name .time();
          $token = sha1($str);
          Redis::set($token,$data->user_id);


      }else{
       echo '用户名或密码错误,请重新登录';
      }
    }

    public function centent(){
        return view('cs.centent');
    }
}
