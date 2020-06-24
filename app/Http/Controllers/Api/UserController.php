<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class UserController extends Controller
{

//    //注册视图
//    public function reg(){
//        return view('user.reg');
//    }

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
}
