<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
//凯撒密码
$router->get('/test1',"TestController@test1");
//对称加密
$router->get('/test',"TestController@test");
$router->post('/test2',"TestController@test2");

//非对称 -》加密
$router->post('/test3',"TestController@test3");
//非对称 -》签名
$router->post('/test4',"TestController@test4");