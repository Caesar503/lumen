<?php

namespace App\Http\Controllers\Goods;

use Laravel\Lumen\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use App\Model\UserApi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class GoodsController extends BaseController
{
   public function goodsinfo()
   {
//       $url = 'http://laravel2.1809.com/goodsinfo';
       $url = 'http://passport.zjdgz.com/goodsinfo';
       echo $this->curl_post($url,[]);
   }
    //加入购物车
    public function addCart()
    {
        $aa = $_POST['gid'];
        $uid =$_POST['id'];
//        $url = "http://laravel2.1809.com/addCart?gid=$aa&uid=$uid";
        $url = "http://passport.zjdgz.com/addCart?gid=$aa&uid=$uid";
        echo $this->curl_get($url);
    }
    //商品详情
    public function goodsDetail()
    {
        $aa = $_POST['gid'];
//        $url = "http://laravel2.1809.com/goodsDetail?gid=$aa";
        $url = "http://passport.zjdgz.com/goodsDetail?gid=$aa";
        echo $this->curl_get($url);
    }
    public function test()
    {
        $aa = 13;
        $uid = 1;
        $url = "http://laravel2.1809.com/addCart?gid=$aa&uid=$uid";
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
    public function curl_get($url)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        $code = curl_errno($ch);
        echo $res;
    }

}