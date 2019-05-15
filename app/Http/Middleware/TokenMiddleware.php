<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $_POST['token'];
        $id = $_POST['id'];
        if(empty($token)||empty($id)){
            $response=[
                'error'=>2,
                'msg'=>'请先登录'
            ];
        }else{
            $k = 'token_'.$id;
            $aa = Redis::get($k);
            if($aa!=$token){
                $response = [
                    'num'=>2,
                    'msg'=>'无效的token',
                ];
            }else{
                $response = $next($request);
            }
        }
        return $response;
    }
}
