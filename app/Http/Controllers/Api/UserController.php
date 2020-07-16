<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    //用户注册接口
    public function reg()
    {
//        echo '111';die;
        $user_name = request()->post("user_name");
//        var_dump($user_name);die;
        $user_email = request()->post("user_email");
        $password = request()->post("password");
        $repassword = request()->post("repassword");
        //密码长度
        $len = strlen($password);
        if($len<6) {
            $response = [
                'errno' => 50001,
                'msg' => '密码长度必须大于6位',
            ];
            return $response;
        }
        //密码一致
        if($password != $repassword) {
            $response = [
                'errno' => 50002,
                'msg' => '两次密码不一致',
            ];
            return $response;
        }
        //验证用户名，邮箱是否存在
        $name = UserModel::where(["user_name"=>$user_name])->first();
        if($name) {
            die("用户名已存在，请重新选择");
        }
        $user_emails = UserModel::where(['user_email'=>$user_email])->first();
        if($user_emails) {
            $response = [
                'errno' => 50003,
                'msg' => '邮箱已存在',
            ];
            return $response;
        }
        //生成密码
        $pass = password_hash($password, PASSWORD_DEFAULT);
        //添加
        $data = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'password' => $pass,
            'reg_time' => time()
        ];
        $res = UserModel::insert($data);
        if($res) {
            $response = [
                'errno' => 0,
                'msg' => '注册成功',
            ];
        } else {
            $response = [
                'errno' => 50005,
                'msg' => '注册成功',
            ];
        }
        return $response;

    }
    //执行登录接口
    public function login()
    {
        $user_name = request()->post("user_name");
        $password = request()->post("password");
        $res =  UserModel::where(['user_name' => $user_name])->first();
        $pass = password_verify($password,$res->password);
        if($pass) {
            //登录成功生成token
            $str = $res->user_id.$res->user_name.time();
            $token = substr(md5($str),10,16).substr(md5($str),0,10);
            $key = $token;
            //保存redis
            Redis::set($key,$res->user_id);
            //bao保存token,后面验证使用
            $data = [
                'uid' => $res->user_id,
                'token' =>$token,
                'expire' => time() + 7200
            ];

            TokenModel::insert($data);
            $response = [
                'errno' => 0,
                'msg' => 'ok',
                'token' =>$token
            ];

        } else {
            $response = [
                'errno' => 50006,
                'msg' => '用户名密码不正确',
            ];
        }
        return $response;
    }
    //个人中心接口
    public function center(Request $request)
    {
        $token = $request->input('token');
        //验证是否有效
        $uid = Redis::get($token);
        if($uid) {
            $user_info = UserModel::find($uid);
            echo $user_info->user_name."欢迎来到个人中心";

        } else {
            $response = [
                'errno' => 50008,
                'msg' => '请登录',
            ];
            return $response;
        }
    }
    //我的订单
    public function orders()
    {
        $arr = [
            '123989280234234223',
            '123989280234234223',
            '323989280234234223',
            '423989280234234223',
            '103989280234234223',
        ];
        //返回给用户的信息
        $response = [
            'errno' => 0,
            'msg' => 'ok',
            'data' =>[
                'orders' => $arr
            ]
        ];
        return $response;
    }
    //购物车
    public function carts()
    {
        $goods = [
            123,
            12,
            5345
        ];
        //返回给用户的信息
        $response = [
            'errno' => 0,
            'msg' => 'ok',
            'data' =>[
                'orders' => $goods
            ]
        ];
        return $response;

    }
}
