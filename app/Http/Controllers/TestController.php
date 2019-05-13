<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class TestController extends BaseController
{
    public function test()
    {
        //解密
        $method = "AES-256-CBC";
        $key = "zhaokai";
        $options =OPENSSL_RAW_DATA;
        $iv = 'qweasdzxcqweasqq';


        //接受传过来的值
        $arr = $_GET['str'];
        //echo $arr;die;
        $data = base64_decode($arr);
        //echo $data;die;

        $decrypted = openssl_decrypt($data, $method,$key,$options,$iv);
//        echo $decrypted;
        if($decrypted){
            $res = [
                'code'=>200,
                'msg'=>'ok'
            ];
            $res1 = openssl_encrypt(json_encode($res),$method,$key,$options,$iv);
//            echo $res1;die;
            return base64_encode($res1);
        }
//        return json_encode($decrypted);
    }
    public function test1()
    {
        //解密
        $method = "AES-256-CBC";
        $key = "zhaokai";
        $options =OPENSSL_RAW_DATA;
        $iv = 'qweasdzxcqweasqq';


        //接受传过来的值
        $arr = $_GET['str'];
        //echo $arr;die;
        $data = base64_decode($arr);
        //echo $data;die;

        $decrypted = openssl_decrypt($data, $method,$key,$options,$iv);
        echo $decrypted;die;
//        return json_encode($decrypted);
    }
    public function test2()
    {
        //解密
        $method = "AES-256-CBC";
        $key = "zhaokai";
        $options =OPENSSL_RAW_DATA;
        $iv = 'qweasdzxcqweasqq';


        //接受传过来的值
        $arr = file_get_contents("php://input");
        //echo $arr;die;
        $data = base64_decode($arr);
        //echo $data;die;

        $decrypted = openssl_decrypt($data, $method,$key,$options,$iv);
//        echo $decrypted;
        if($decrypted){
            $res = [
                'code'=>200,
                'msg'=>'ok'
            ];
            $res1 = openssl_encrypt(json_encode($res),$method,$key,$options,$iv);
//            echo $res1;die;
            return base64_encode($res1);
        }
//        return json_encode($decrypted);
    }
    public function test3()
    {
        $arr = file_get_contents("php://input");
        $arr1 = base64_decode($arr);
        //获取公钥
        $pk1 = openssl_pkey_get_public("file://".storage_path('app/keys/rsa_public_key.pem'));
        //通过公钥进行解密
        openssl_public_decrypt($arr1,$pk_den,$pk1);
//        dump(json_decode($pk_den,true));


        //通过公钥加密返回数据
        $respon=[
            'error'=>0,
            'msg'=>'ok'
        ];
        openssl_public_encrypt(json_encode($respon,JSON_UNESCAPED_UNICODE),$pk_enc,$pk1);
        return base64_encode($pk_enc);

    }
    public function test4()
    {
        //获取post传的值
        $res = file_get_contents("php://input");
//        echo $res;die;
        $post = base64_decode($res);
//        echo $post;
        //获取签名
        $res1 = $_GET['sign'];
        $sign = base64_decode($res1);
//        echo $sign;
        //获取公钥
        $pk = openssl_get_publickey("file://".storage_path("app/keys/rsa_public_key.pem"));
        //验证签名
        $check = openssl_verify($post,$sign,$pk);
        if($check !=1){
            echo "签名错误";
        }else{
            echo "签名验证成功";
        }
    }
}
