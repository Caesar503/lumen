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

    //登录
    public function login(Request $request)
    {
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $data= [
            'email'=>$email,
            'pass'=>$pass
        ];
//        $url = "http://laravel2.1809.com/login";
        $url = "http://passport.zjdgz.com/login";
        echo $this->curl_post($url,$data);
        //创建一个curl资源
//        $ch = curl_init();
//        curl_setopt($ch,CURLOPT_URL,$url); //url
//        curl_setopt($ch,CURLOPT_POST,1);//post
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//不在浏览器上显示
//        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));//传输数据
//        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']); //header头 -》传输内容类型
//        $res = curl_exec($ch);
//        $code = curl_errno($ch);
//        echo $res;

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

    public function userinfo()
    {
//        header('Access-Control-Allow-Origin:*');
//        header('Access-Control-Allow-Method:OPTIONS,GET,POST');
//        header('Access-Control-Allow-Headers:x-requested-with');
        $id = $_POST['id'];
//        $k = 'token_'.$id;
//        $aa = Redis::get($k);
//        if($aa!=$token){
//            $arr = [
//                'num'=>2,
//                'msg'=>'无效的token',
//            ];
//        }else{
            //查询信息
            $userinfo = UserApi::where('id',$id)->first();
            if(!$userinfo){
                $arr = [
                    'num'=>2,
                    'msg'=>'请先登录',
                ];
            }else{
                $arr = [
                    'num'=>1,
                    'msg'=>'hello '.$userinfo->username,
                ];
            }
//        }
        echo json_encode($arr);
    }


    public function aaaa()
    {
        $data= [
            'email'=>'zzz@zzz.com',
            'pass'=>'zzzzzz'
        ];
        //创建一个curl资源
        $ch = curl_init();
        $url = "http://laravel2.1809.com/login";
        curl_setopt($ch,CURLOPT_URL,$url); //url
        curl_setopt($ch,CURLOPT_POST,1);//post
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//不在浏览器上显示
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));//传输数据
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']); //header头 -》传输内容类型
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        echo $res;
    }

    //注册
    public function h_regist()
    {
        $data= $_POST;
//        $url = "http://laravel2.1809.com/regist";
        $url = "http://passport.zjdgz.com/regist";
        echo $this->curl_post($url,$data);
    }
    //curl
    function curl_post($url,$data=[])
    {
        $ch = curl_init();//创建一个curl资源
        curl_setopt($ch,CURLOPT_URL,$url); //url
        curl_setopt($ch,CURLOPT_POST,1);//post
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);//不在浏览器上显示
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));//传输数据
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']); //header头 -》传输内容类型
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        echo $res;
    }
}