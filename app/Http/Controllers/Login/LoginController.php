<?php

namespace App\Http\Controllers\Login;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Model\UserApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class LoginController extends BaseController
{
    public function regist(Request $request)
    {
        $data = file_get_contents("php://input");
        $arr_data = base64_decode($data);

        //解密
        $private_k = openssl_get_privatekey("file://".storage_path("app/keys/rsa_private_key.pem"));
        openssl_private_decrypt($arr_data,$json_data,$private_k);

        $res = UserApi::insertGetId(json_decode($json_data,true));
        if($res)
        {
            echo "注册成功";
        }else
        {
            echo "注册失败";
        }
    }
    public function login(Request $request)
    {
//        $data = file_get_contents("php://input");
//        dd($data);
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        echo $email;die;
        $e = UserApi::where('email',$email)->first();
        if($e){
            if(!password_verify($pass,$e['pass']))
            {
                die('密码不正确');
            }else
            {
                //生成token
                $token = $this->token($e['id']);
                //存储cookie
                //setcookie('token',$token,time()+3600*24*7,"/","1809.com",false,true);

                //存储Redis
//                $k = 'token_'.$e['id'];
                $k = 'token_';

                $r = [
                    'token'=>$token,
                    'name'=>$e['username']
                ];
                Redis::set($k,json_encode($r));
                Redis::expire($k,3600*24*7);
                die('登陆成功');
            }
        }else
        {
            die('邮箱不存在');
        }
    }
    function token($id)
    {
        return substr(Str::random(8).$id.time().rand(1000,9999),5,15);
    }
    public function test_t()
    {
//        header("Access-Control-Allow-Origin:http://client_laravel.1809.com");
        if($_POST['aa']){
            echo $_POST['aa'];
        }else{
            echo "eiyou";
        }
    }
}