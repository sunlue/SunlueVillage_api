<?php
// [ 应用入口文件 ]
namespace think;
require __DIR__ . '/../vendor/autoload.php';
// 执行HTTP应用并响应
$http = (new App())->http;
//执行应用程序
$response = $http->run();
//发送数据到客户端
$response->send();
$http->end($response);
