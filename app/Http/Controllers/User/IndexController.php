<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class IndexController extends Controller
{
    //注册
    public function reg()
    {
        return view('user.reg.index');
    }
    //执行注册
    public function regDo()
    {
        $user_name = request()->post("user_name");
        $user_email = request()->post("user_email");
        $password = request()->post("password");
        $repassword = request()->post("repassword");
        //密码长度
        $len = strlen($password);
        if($len<6) {
            die("密码长度必须大于6位");
        }
        //密码一致
        if($password != $repassword) {
            die("两次密码不一致");
        }
        //验证用户名，邮箱是否存在
        $name = UserModel::where(["user_name"=>$user_name])->first();
        if($name) {
            die("用户名已存在，请重新选择");
        }
        $user_emails = UserModel::where(['user_email'=>$user_email])->first();
        if($user_emails) {
            die("邮箱已存在，请重新选择");
        }
        //生成密码
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $data = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'password' => $pass,
            'reg_time' => time()
        ];
        $res = UserModel::insert($data);
        if($res) {
            return view('user.reg.login');
        }

    }
    //登录
    public function login()
    {
        return view('user.reg.login');
    }
   //执行登录
    public function loginDo()
    {
        $user_name = request()->post("user_name");
        $password = request()->post("password");
        $res =  UserModel::where(['user_name' => $user_name])->first();
        $pass = password_verify($password,$res->password);
        if($pass) {
            //向客户端设置cookie
            setcookie('uid',$res->user_id,time()+3600,'/');

            header('Refresh:2;url=/user/centers');
            echo "登录成功";
        } else {
            header('Refresh:2;url=/user/login');
            echo "用户名或密码不一致";
        }
    }
    //个人中心
    public function centers()
    {
        //判断用户是否登录，是否有uid或name字段，
        if(isset($_COOKIE['uid'])) {

            return view('user.reg.center');
        } else {

            return view('user.reg.login');
        }
    }
}
