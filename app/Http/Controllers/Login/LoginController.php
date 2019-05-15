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
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $e = UserApi::where('email',$email)->first();
        if($e){
            if(!password_verify($pass,$e['pass']))
            {
                $arr = [
                    'num'=>2,
                    'error'=>"密码错误"
                ];
                echo json_encode($arr);
                die;
            }else
            {
                //生成token
                $token = $this->token($e['id']);


//                存储Redis
                $k = 'token_'.$e['id'];
//                $k = 'token_';
                Redis::set($k,$token);
                Redis::expire($k,3600*24*7);

                $arr = [
                    'num'=>1,
                    'error'=>"登陆成功",
                    'token'=>$token,
                    'id'=>$e['id'],
                ];
                echo json_encode($arr);
                die;
            }
        }else
        {
            $arr = [
                'num'=>2,
                'error'=>"邮箱错误"
            ];
            echo json_encode($arr);
            die;
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
}