<?php

if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {

    include_once "./lib/fun.php";

    // trim 用语过滤空格
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (!$username) {
        showMsg(0, "用户名不能为空");
    }
    if (!$password) {
        showMsg(0, "密码不能为空");
    }
    if (!$repassword) {
        showMsg(0, "确认密码不能为空");
    }
    if ($password !== $repassword) {
        showMsg(0, "两次密码输入不一致");
    }

    // 连接数据库
    $conn = mysqlInit("localhost", "root", "password", "mall");
    if (!$conn) {
        echo $conn->errno;
        exit;
    }

    // 判断数据表中是否有相同用户名

    $sql = "SELECT COUNT(`id`) AS `total` FROM `user` WHERE `username` = '{$username}'";

    $result_obj = $conn->query($sql);
    $result = $result_obj->fetch_assoc();

    // 验证用户名是否存在
    if (isset($result['total']) && $result['total'] > 0) {
        showMsg(0, "用户名已存在，请重新输入！");
    }

    // 密码加密处理
    $password = pwdEncrypt($password);

    //插入数据库
    unset($sql, $result, $result_obj);
    $registerTime = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `user` (`username`, `password`, `create_time`)" .
        " VALUES ('{$username}', '{$password}', '{$registerTime}')";

    $result = $conn->query($sql);
    if (!$result) {
        showMsg(0, "注册失败！Error: {$conn->error}");
    } else {
        $userID = $conn->insert_id;
        showMsg(1, "用户名为：{$username}，用户ID为：{$userID}", "login.php");
    }

    // 关闭数据库连接
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|用户注册</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
    <link rel="stylesheet" type="text/css" href="./static/css/login.css">
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="./static/image/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <li><a href="./">首页</a></li>
            <li><a href="login.php">登录</a></li>
            <li><a href="register.php">注册</a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="center">
        <div class="center-login">
            <div class="login-banner">
                <a href="#"><img src="./static/image/login_banner.png" alt=""></a>
            </div>
            <div class="user-login">
                <div class="user-box">
                    <div class="user-title">
                        <p>用户注册</p>
                    </div>
                    <form class="login-table" name="register" id="register-form" action="register.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input type="text" class="yhmiput" name="username" placeholder="Username" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input type="password" class="yhmiput" name="password" placeholder="Password" id="password">
                        </div>
                        <div class="login-right">
                            <label class="passwd">确认</label>
                            <input type="password" class="yhmiput" name="repassword" placeholder="Repassword"
                                   id="repassword">
                        </div>
                        <div class="login-btn">
                            <button type="submit">注册</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <p><span>M-GALLARY</span> ©2017 POWERED BY IMOOC.INC</p>
</div>

</body>
<script src="./static/js/jquery-1.10.2.min.js"></script>
<script src="./static/js/layer/layer.js"></script>
<script>
    $(function () {
        $('#register-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val(),
                repassword = $('#repassword').val();
            if (username == '' || username.length <= 0) {
                layer.tips('用户名不能为空', '#username', {time: 2000, tips: 2});
                $('#username').focus();
                return false;
            }

            if (password == '' || password.length <= 0) {
                layer.tips('密码不能为空', '#password', {time: 2000, tips: 2});
                $('#password').focus();
                return false;
            }

            if (repassword == '' || repassword.length <= 0 || (password != repassword)) {
                layer.tips('两次密码输入不一致', '#repassword', {time: 2000, tips: 2});
                $('#repassword').focus();
                return false;
            }

            return true;
        })

    })
</script>
</html>


