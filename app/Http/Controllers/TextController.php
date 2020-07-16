<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;
use DB;

class TextController extends Controller
{
    //
    public function hello()
    {
        $data = DB::table('p_goods')->first();// 查一条数据
        print_r($data);
    }

    //登录
    public function login()
    {
        return view('text.logins.login');
    }
    //loginDo
    public function loginDo()
    {
        $data = request()->except('_token');
        $str = implode($data); //加密使用字符串，进行一个数组转字符串
        $user_name = $data['user_name'];
        $password = $data['password'];
        //获取私钥
        $key = openssl_get_privatekey(file_get_contents(storage_path('keys/a_priv.key')));
        openssl_sign($str,$sign,$key);
        $sign_st = urlencode(base64_encode($sign));//解密一大串，然后发送
        $url = 'http://www.api.com/text/login_one?user_name='.$user_name.'&password='.$password.'&sign_st'.$sign_st;
        $response = file_get_contents($url);
        echo $response;



    }

}
