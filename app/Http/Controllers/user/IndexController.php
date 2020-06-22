<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $pass1 = $request->input('password1');
        $pass2 = $request->input('password2');
        $name = $request->input('user_name');
        $emali = $request->input('email');

        //密码长度是否大于6
        $len = strlen($pass1);
        if($len>6){
            die('密码长度必须大于6位数');
        }

        if($pass1!=$pass2){
            die('两次密码输入不一致');
        }

        if(empty($name)){
            die('名称必填');
        }
        if(empty($emali)){
            die('邮箱必填');
        }
    }
}
