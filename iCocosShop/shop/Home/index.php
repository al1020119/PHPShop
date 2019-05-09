<?php
session_start();
error_reporting(0);
//手动配置文件
include '../Admin/Conf/config.php';
//自动加载
function __autoload($name)
{   

    if(file_exists("./Controller/{$name}.class.php")){ 
        include "./Controller/{$name}.class.php";
    } elseif(file_exists("../Admin/Controller/{$name}.class.php")){
            include "../Admin/Controller/{$name}.class.php";
    }else{
        header('location:./Public/404.html');
    }
}

//c传过来的值决定类，a传过来的值决定方法
$c=isset($_GET['c']) ? $_GET['c'] : "Home";
$a=isset($_GET['a']) ? $_GET['a'] : "index";


if(!preg_match('/^[0-9a-zA-Z]+$/i',$c)) header('location:./Public/404.html');

if(!preg_match('/^[0-9a-zA-Z]+$/i',$a)) header('location:./Public/404.html');
$obj = new $c();
if(method_exists($obj,$a)){
    $obj->$a();
}else{
    header('location:./Public/404.html');
}
