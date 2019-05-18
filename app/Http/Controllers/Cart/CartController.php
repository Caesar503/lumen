<?php

namespace App\Http\Controllers\Cart;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Model\UserApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class CartController extends BaseController
{
    //购物车列表
    public function cartList()
    {
        $uid = $_POST['id'];
//        $url = "http://laravel2.1809.com/cartList?uid=$uid";
        $url = "http://passport.zjdgz.com/cartList?uid=$uid";
        echo $this->curl_get($url);
    }
    //测试购物车列表
    public function cart()
    {
        $uid = 13;
        $url = "http://laravel2.1809.com/cartList?uid=$uid";
        echo $this->curl_get($url);
    }
    //curl ->post
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
    //curl -> get
    function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        echo $res;
    }
    //生成订单
    public function createOrder()
    {
        $uid = $_POST['id'];
//        $url = "http://laravel2.1809.com/createOrder?uid=$uid";
        $url = "http://passport.zjdgz.com/createOrder?uid=$uid";
        echo $this->curl_get($url);
    }
    //订单列表
    public function orderList()
    {
        $uid = $_POST['id'];
//        $url = "http://laravel2.1809.com/orderList?uid=$uid";
        $url = "http://passport.zjdgz.com/orderList?uid=$uid";
        echo $this->curl_get($url);
    }
}