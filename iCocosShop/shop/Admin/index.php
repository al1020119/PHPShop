<?php
session_start();
error_reporting(0);
if(isset($_SESSION['username']['role'])&&$_SESSION['username']['role']=='1')header('location:index.php?c=Login&a=logout');
//手动配置文件
include './Conf/config.php';
//自动加载
function __autoload($name)
{
    if(!file_exists("./Controller/{$name}.class.php")) header('location:index.php?c=Login&a=logout');
    include "./Controller/{$name}.class.php";
}

//c传过来的值决定类，a传过来的值决定方法
$c=isset($_GET['c']) ? $_GET['c'] : "User";
$a=isset($_GET['a']) ? $_GET['a'] : "index";


if(!preg_match('/^[0-9a-zA-Z]+$/i',$c)) header('location:index.php?c=Login&a=logout');

if(!preg_match('/^[0-9a-zA-Z]+$/i',$a)) header('location:index.php?c=Login&a=logout');
$obj = new $c();
if(method_exists($obj,$a)){
    $obj->$a();
}else{
    header('location:index.php?c=Login&a=logout');
}


// var_dump($_GET['c']);
//var_dump($_COOKIE);