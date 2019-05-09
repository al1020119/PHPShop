<?php

include_once "./lib/fun.php";
// 开启session
session_start();

// 判断用户是否登录
if ($login = (isset($_SESSION['user']) && !empty($_SESSION['user']))) {
    unset($_SESSION["user"]);
    showMsg(1, "退出成功", "./");
}
